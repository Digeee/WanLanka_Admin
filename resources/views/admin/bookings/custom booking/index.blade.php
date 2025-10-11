@extends('admin.layouts.master')

@section('content')
<style>
    /* ====== Design Tokens (Light / Dark) ====== */
    :root{
        --bg: #f8fafc;
        --panel: #ffffff;
        --muted: #64748b;
        --text: #0f172a;
        --border: #e2e8f0;
        --ring: #cbd5e1;
        --accent: #3b82f6;
        --accent-2: #22c55e;
        --danger: #ef4444;
        --warning: #f59e0b;
        --radius: 16px;
        --shadow-1: 0 10px 20px rgba(2,6,23,.06);
        --shadow-2: 0 18px 40px rgba(2,6,23,.08);
        --glass: blur(10px) saturate(1.05);
    }
    [data-theme="dark"]{
        --bg: #0b1220;
        --panel: #0f172a;
        --muted: #94a3b8;
        --text: #e5e7eb;
        --border: #1f2937;
        --ring: #334155;
        --accent: #60a5fa;
        --accent-2: #34d399;
        --danger: #f87171;
        --warning: #fbbf24;
        --shadow-1: 0 10px 22px rgba(0,0,0,.35);
        --shadow-2: 0 22px 50px rgba(0,0,0,.45);
        --glass: blur(10px) saturate(1.05);
    }

    /* ====== Page Shell ====== */
    .shell{ max-width:1200px; margin:28px auto 80px; padding:0 20px; color:var(--text); }
    body{
        background:
           radial-gradient(1200px 600px at 10% -10%, color-mix(in oklab, var(--accent), transparent 94%), transparent),
           var(--bg);
    }

    /* Header */
    .page-header{
        display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:24px;
        background: linear-gradient(180deg, color-mix(in oklab, var(--panel), transparent 4%), transparent);
        border:1px solid var(--border); border-radius:16px; padding:12px 16px; box-shadow: var(--shadow-1);
    }
    .title{ margin:0; font-size:26px; font-weight:800; letter-spacing:.2px; }
    .subtitle{ margin:4px 0 0; font-size:14px; color:var(--muted); }
    .actions{ display:flex; gap:10px; flex-wrap:wrap; }

    /* Stats */
    .stats{
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap:20px;
        margin-bottom:30px;
    }
    .stat-card{
        background: var(--panel);
        border:1px solid var(--border);
        border-radius:var(--radius);
        padding:20px;
        text-align:center;
        box-shadow: var(--shadow-1);
    }
    .stat-value{
        font-size:2rem;
        font-weight:800;
        margin-bottom:5px;
    }
    .stat-label{
        color:var(--muted);
        font-size:0.9rem;
    }

    /* ====== Buttons (gloss, gradient border) ====== */
    .btn{
        --fg: var(--text);
        --bd: var(--ring);
        --fill: color-mix(in oklab, var(--panel), transparent 8%);
        --shine: linear-gradient(115deg, transparent 0%, rgba(255,255,255,.16) 45%, rgba(255,255,255,.28) 55%, transparent 70%);

        position: relative; isolation:isolate;
        appearance:none; cursor:pointer;
        font-weight:800; letter-spacing:.3px; font-size:14px;
        border-radius:999px; padding:10px 16px;
        text-decoration:none; display:inline-flex; align-items:center; gap:8px;

        background-image:
          var(--shine),
          linear-gradient(var(--fill), var(--fill)),
          linear-gradient(135deg, var(--bd), color-mix(in oklab, var(--bd), #000 12%));
        background-origin: padding-box, padding-box, border-box;
        background-clip: padding-box, padding-box, border-box;
        background-size: 220% 100%, 100% 100%, 100% 100%;
        background-position: -120% 0, 0 0, 0 0;

        border:1.5px solid transparent;
        color: var(--fg);
        box-shadow: var(--shadow-1);
        transition:
          background-position .6s ease,
          box-shadow .25s ease,
          color .25s ease,
          border-color .25s ease;
        overflow:hidden;
        backface-visibility:hidden; transform:translateZ(0);
    }
    .btn:hover{
        background-position: 120% 0, 0 0, 0 0;
        box-shadow: var(--shadow-2);
    }
    .btn:active{ transform: translateY(1px); }
    .btn:focus-visible{
        outline:none;
        box-shadow: 0 0 0 3px color-mix(in oklab, var(--accent), transparent 60%), var(--shadow-2);
    }

    [data-theme="dark"] .btn{
        --shine: linear-gradient(115deg, transparent 0%, rgba(255,255,255,.08) 45%, rgba(255,255,255,.14) 55%, transparent 70%);
        --fill: color-mix(in oklab, var(--panel), transparent 12%);
        color: color-mix(in oklab, var(--text), white 12%);
    }

    /* Primary */
    .btn-primary{
        --fg: color-mix(in oklab, var(--accent), #000 35%);
        --bd: color-mix(in oklab, var(--accent), #000 15%);
        --fill: color-mix(in oklab, var(--panel), transparent 0%);
    }
    .btn-primary:hover{
        color:#fff; text-shadow: 0 1px 0 rgba(0,0,0,.25);
        background-image:
          var(--shine),
          linear-gradient(180deg, color-mix(in oklab, var(--accent), #000 10%), var(--accent)),
          linear-gradient(135deg, color-mix(in oklab, var(--accent), #000 15%), color-mix(in oklab, var(--accent), #000 26%));
        border-color: transparent;
    }
    [data-theme="dark"] .btn-primary{
        --fg: color-mix(in oklab, var(--accent), white 45%);
        --bd: color-mix(in oklab, var(--accent), white 18%);
        --fill: color-mix(in oklab, var(--panel), transparent 10%);
    }

    /* Danger */
    .btn-danger{
        --fg: color-mix(in oklab, var(--danger), #000 25%);
        --bd: color-mix(in oklab, var(--danger), #000 18%);
        --fill: color-mix(in oklab, var(--panel), transparent 0%);
    }
    .btn-danger:hover{
        color:#fff; text-shadow: 0 1px 0 rgba(0,0,0,.25);
        background-image:
          var(--shine),
          linear-gradient(180deg, color-mix(in oklab, var(--danger), #000 8%), var(--danger)),
          linear-gradient(135deg, color-mix(in oklab, var(--danger), #000 18%), color-mix(in oklab, var(--danger), #000 28%));
        box-shadow: 0 14px 30px rgba(239,68,68,.35);
        border-color: transparent;
    }
    [data-theme="dark"] .btn-danger{
        --fg: color-mix(in oklab, var(--danger), white 40%);
        --bd: color-mix(in oklab, var(--danger), white 22%);
        --fill: color-mix(in oklab, var(--panel), transparent 10%);
    }

    /* Ghost (for View button) */
    .btn-ghost{
        --fg: var(--muted);
        --bd: var(--border);
        --fill: transparent;
    }
    .btn-ghost:hover{
        --fg: var(--text);
        background-image:
          var(--shine),
          linear-gradient(var(--fill), var(--fill)),
          linear-gradient(135deg, var(--bd), color-mix(in oklab, var(--bd), #000 12%));
    }
    [data-theme="dark"] .btn-ghost{
        --fg: var(--muted);
    }
    [data-theme="dark"] .btn-ghost:hover{
        --fg: var(--text);
    }

    /* Panel */
    .panel{ background:var(--panel); border:1px solid var(--border); border-radius:var(--radius); box-shadow:var(--shadow-1); overflow:hidden; }
    .panel-header{
        display:flex; justify-content:space-between; align-items:center;
        padding:14px 16px; border-bottom:1px solid var(--border);
        font-weight:800;
    }
    .panel-title{ margin:0; font-size:16px; }
    .panel-actions{ display:flex; align-items:center; gap:12px; }

    /* Search */
    .search-box{
        position:relative;
        display:flex; align-items:center;
    }
    .search-box input{
        padding-left:35px;
        padding-right:12px;
        height:36px;
        width:240px;
        border:1px solid var(--border);
        border-radius:10px;
        background:var(--panel);
        color:var(--text);
        font-size:14px;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
    }
    .search-box input:focus{
        outline:none;
        border-color:var(--accent);
        box-shadow: 0 0 0 3px color-mix(in oklab, var(--accent), transparent 60%);
    }
    .search-box svg{
        position:absolute;
        left:10px;
        width:18px;
        height:18px;
        color:var(--muted);
    }

    /* Table */
    .table-wrap{ overflow:auto; border:1px solid var(--border); border-radius:14px; }
    table.data{ width:100%; border-collapse:separate; border-spacing:0; min-width:780px; background:color-mix(in oklab, var(--panel), transparent 2%); }
    .data thead th{
        position:sticky; top:0; z-index:1; text-align:left; font-size:12px; text-transform:uppercase; letter-spacing:.5px;
        color:var(--muted); background: color-mix(in oklab, var(--panel), transparent 2%);
        border-bottom:1px solid var(--border); padding:12px 14px;
    }
    .data tbody td{ padding:14px; border-bottom:1px solid var(--border); vertical-align:middle; }
    .data tbody tr:hover{ background: color-mix(in oklab, var(--panel), transparent 6%); }

    /* Chips for Status */
    .chip{ display:inline-flex; align-items:center; gap:8px; height:28px; padding:0 12px; border-radius:999px;
           border:1px solid var(--ring); font-size:12px; font-weight:800; color:var(--text);
           background: color-mix(in oklab, var(--panel), transparent 8%); }
    .chip-dot{ width:8px; height:8px; border-radius:999px; }
    .chip-active{ color: var(--accent-2); border-color: color-mix(in oklab, var(--accent-2), #000 15%); }
    .chip-inactive{ color: var(--muted); border-color: var(--muted); }
    .chip-warning{ color: var(--warning); border-color: var(--warning); }
    .chip-danger{ color: var(--danger); border-color: var(--danger); }
    .chip-active .chip-dot{ background: var(--accent-2); }
    .chip-inactive .chip-dot{ background: var(--muted); }
    .chip-warning .chip-dot{ background: var(--warning); }
    .chip-danger .chip-dot{ background: var(--danger); }

    /* Pagination */
    .pagination-wrapper{ margin-top:16px; }
    nav .pagination{ display:flex; gap:8px; flex-wrap:wrap; padding:12px 0; }
    .page-item{ list-style:none; }
    .page-link{
        display:inline-flex; align-items:center; justify-content:center; min-width:36px; height:36px;
        padding:0 12px; border-radius:10px; border:1px solid var(--border); text-decoration:none;
        color:var(--text); background:var(--panel); box-shadow:var(--shadow-1); font-weight:700;
        transition: box-shadow .2s ease, background-color .2s ease, color .2s ease, border-color .2s ease;
    }
    .page-item.active .page-link{ background: color-mix(in oklab, var(--accent), #000 8%); color:#fff; border-color: color-mix(in oklab, var(--accent), #000 18%); }
    .page-link:hover{ box-shadow: var(--shadow-2); }

    /* Responsive */
    @media (max-width: 768px) {
        .stats{ grid-template-columns: 1fr; }
        .page-header{ flex-direction: column; align-items: stretch; }
        .actions{ justify-content: center; }
        .search-box input{ width:100%; }
    }
</style>

<div class="shell" id="custom-packages-root">
    <div class="page-header">
        <div>
            <h1 class="title">Custom Packages</h1>
            <p class="subtitle">Manage all custom tour packages</p>
        </div>
        <div class="actions">
            <button class="btn" id="themeToggle" type="button">Theme</button>
            <a href="{{ route('admin.custom-packages.create') }}" class="btn btn-primary">Add New Custom Package</a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats">
        <div class="stat-card">
            <div class="stat-value">{{ $packages->total() }}</div>
            <div class="stat-label">Total Packages</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $packages->where('status', 'active')->count() }}</div>
            <div class="stat-label">Active Packages</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $packages->where('status', 'inactive')->count() }}</div>
            <div class="stat-label">Inactive Packages</div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Custom Package List</h2>
            <div class="panel-actions">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search packages...">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-wrap">
                <table class="data">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>User</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th style="min-width:240px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($packages as $package)
                        <tr>
                            <td style="font-weight:800;">{{ $package->title }}</td>
                            <td>{{ $package->user->name ?? 'N/A' }}</td>
                            <td>{{ $package->duration }} days</td>
                            <td>{{ $package->price ? 'LKR ' . number_format($package->price, 2) : 'N/A' }}</td>
                            <td>
                                @php
                                    $status = strtolower($package->status);
                                @endphp
                                @if($status === 'active' || $status === 'approved')
                                    <span class="chip chip-active"><span class="chip-dot"></span>{{ ucfirst($package->status) }}</span>
                                @elseif($status === 'pending')
                                    <span class="chip chip-warning"><span class="chip-dot"></span>{{ ucfirst($package->status) }}</span>
                                @elseif($status === 'rejected')
                                    <span class="chip chip-danger"><span class="chip-dot"></span>{{ ucfirst($package->status) }}</span>
                                @else
                                    <span class="chip chip-inactive"><span class="chip-dot"></span>{{ ucfirst($package->status) }}</span>
                                @endif
                            </td>
                            <td style="font-size:13px; color:var(--muted);">
                                {{ $package->created_at->format('M j, Y') }}
                            </td>
                            <td>
                                <div class="actions" style="gap:8px;">
                                    <a href="{{ route('admin.custom-packages.show', $package) }}" class="btn btn-ghost">View</a>
                                    <a href="{{ route('admin.custom-packages.edit', $package) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('admin.custom-packages.destroy', $package) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this package?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:24px; color:var(--muted);">
                                No custom packages found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                {{ $packages->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    // Theme toggle
    (function(){
        const key = 'ui-theme';
        const root = document.documentElement;
        const btn = document.getElementById('themeToggle');
        const saved = localStorage.getItem(key);
        if(saved === 'dark'){ root.setAttribute('data-theme','dark'); }
        btn?.addEventListener('click', ()=>{
            const dark = root.getAttribute('data-theme') === 'dark';
            root.setAttribute('data-theme', dark ? 'light' : 'dark');
            localStorage.setItem(key, dark ? 'light' : 'dark');
        });
        if(!saved && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches){
            root.setAttribute('data-theme','dark');
        }
    })();

    // Search functionality
    document.getElementById('searchInput')?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const title = row.cells[0]?.textContent.toLowerCase() || '';
            const user = row.cells[1]?.textContent.toLowerCase() || '';
            const duration = row.cells[2]?.textContent.toLowerCase() || '';
            const price = row.cells[3]?.textContent.toLowerCase() || '';
            
            const match = title.includes(searchTerm) || 
                         user.includes(searchTerm) || 
                         duration.includes(searchTerm) || 
                         price.includes(searchTerm);
            
            row.style.display = match ? '' : 'none';
        });
    });
</script>
@endsection