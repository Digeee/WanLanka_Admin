@extends('admin.layouts.master')

@section('content')
<style>
    /* ====== Design Tokens (Light / Dark) ====== */
    :root{
        --bg:#f8fafc; --panel:#ffffff; --muted:#64748b; --text:#0f172a;
        --border:#e2e8f0; --ring:#cbd5e1; --accent:#3b82f6; --accent-2:#22c55e;
        --danger:#ef4444; --warning:#f59e0b; --radius:16px;
        --shadow-1:0 10px 20px rgba(2,6,23,.06);
        --shadow-2:0 18px 40px rgba(2,6,23,.08);
        --glass:blur(10px) saturate(1.05);
    }
    [data-theme="dark"]{
        --bg:#0b1220; --panel:#0f172a; --muted:#94a3b8; --text:#e5e7eb;
        --border:#1f2937; --ring:#334155; --accent:#60a5fa; --accent-2:#34d399;
        --danger:#f87171; --warning:#fbbf24;
        --shadow-1:0 10px 22px rgba(0,0,0,.35);
        --shadow-2:0 22px 50px rgba(0,0,0,.45);
        --glass:blur(10px) saturate(1.05);
    }

    /* ====== Glass Morphism Enhancements ====== */
    .glass-effect {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(12px) saturate(180%);
        -webkit-backdrop-filter: blur(12px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
    }

    [data-theme="dark"] .glass-effect {
        background: rgba(15, 23, 42, 0.45);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
    }

    /* ====== Shell & Header ====== */
    .shell{max-width:1200px;margin:28px auto 80px;padding:0 20px;color:var(--text);}
    .page-header{
        display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:18px;
        background:linear-gradient(180deg,color-mix(in oklab,var(--panel),transparent 4%),transparent);
        border:1px solid var(--border);border-radius:18px;padding:14px 18px;box-shadow:var(--shadow-1);
        /* Enhanced glass effect */
        background: rgba(255, 255, 255, 0.35);
        backdrop-filter: blur(12px) saturate(180%);
        -webkit-backdrop-filter: blur(12px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
    }
    [data-theme="dark"] .page-header{
        background:
          radial-gradient(1200px 150px at 10% -40%, rgba(59,130,246,.12), transparent 70%),
          linear-gradient(180deg,#0f172a 0%, #0b1220 100%);
        border:1px solid var(--ring);
        box-shadow:0 18px 50px rgba(2,6,23,.55), inset 0 1px 0 rgba(255,255,255,.04);
        /* Enhanced dark glass effect */
        background: rgba(15, 23, 42, 0.55);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
    }
    .breadcrumbs{font-size:12px;color:var(--muted);}
    .breadcrumbs a{color:inherit;text-decoration:none;}
    .title{margin:0;font-size:28px;font-weight:800;letter-spacing:.2px;color:var(--text);}
    [data-theme="dark"] .title{color:#f8fafc;text-shadow:0 1px 0 rgba(0,0,0,.45);}
    .actions{display:flex;gap:12px;flex-wrap:wrap;}

    /* ====== Panel / Table ====== */
    .panel{
        background:var(--panel);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-1);overflow:hidden;
        /* Enhanced glass effect */
        background: rgba(255, 255, 255, 0.45);
        backdrop-filter: blur(12px) saturate(180%);
        -webkit-backdrop-filter: blur(12px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
    }
    .panel-header{
        padding:14px 16px;border-bottom:1px solid var(--border);font-weight:800;
        background:
          linear-gradient(180deg,color-mix(in oklab,var(--panel),transparent 92%),transparent),
          radial-gradient(1000px 100px at 0 -30%,color-mix(in oklab,var(--accent),transparent 92%),transparent);
        /* Enhanced glass effect */
        background: rgba(255, 255, 255, 0.55);
        backdrop-filter: blur(12px) saturate(180%);
        -webkit-backdrop-filter: blur(12px) saturate(180%);
        border-bottom: 1px solid rgba(255, 255, 255, 0.18);
    }
    [data-theme="dark"] .panel-header {
        background: rgba(15, 23, 42, 0.65);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    .panel-body{padding:18px;}

    .table-wrap{
        overflow:auto;border:1px solid var(--border);border-radius:14px;
        /* Enhanced glass effect */
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(8px) saturate(180%);
        -webkit-backdrop-filter: blur(8px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }
    [data-theme="dark"] .table-wrap {
        background: rgba(15, 23, 42, 0.35);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    table.data{width:100%;border-collapse:separate;border-spacing:0;min-width:900px;background:color-mix(in oklab,var(--panel),transparent 2%);}
    .data thead th{
        position:sticky;top:0;z-index:1;text-align:left;font-size:12px;text-transform:uppercase;letter-spacing:.5px;
        color:var(--muted);background:color-mix(in oklab,var(--panel),transparent 2%);
        border-bottom:1px solid var(--border);padding:12px 14px;
        /* Enhanced glass effect */
        background: rgba(255, 255, 255, 0.45);
        backdrop-filter: blur(8px) saturate(180%);
        -webkit-backdrop-filter: blur(8px) saturate(180%);
    }
    [data-theme="dark"] .data thead th {
        background: rgba(15, 23, 42, 0.45);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    .data tbody td{padding:14px;border-bottom:1px solid var(--border);vertical-align:middle;}
    .data tbody tr:hover{
        background:color-mix(in oklab,var(--panel),transparent 6%);
        /* Enhanced hover effect */
        background: rgba(255, 255, 255, 0.35);
    }
    [data-theme="dark"] .data tbody tr:hover {
        background: rgba(15, 23, 42, 0.55);
    }

    /* Chips */
    .chip{
        display:inline-flex;align-items:center;gap:8px;height:28px;padding:0 12px;border-radius:999px;
        border:1px solid var(--ring);font-size:12px;font-weight:800;color:var(--text);
        background:color-mix(in oklab,var(--panel),transparent 8%);
        /* Enhanced glass effect */
        background: rgba(255, 255, 255, 0.35);
        backdrop-filter: blur(6px) saturate(180%);
        -webkit-backdrop-filter: blur(6px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }
    [data-theme="dark"] .chip {
        background: rgba(15, 23, 42, 0.45);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .chip-dot{width:8px;height:8px;border-radius:999px;}
    .chip-active{color:var(--accent);border-color:color-mix(in oklab,var(--accent),#000 15%);}
    .chip-inactive{color:var(--warning);border-color:var(--warning);}
    .chip-active .chip-dot{background:var(--accent-2);}
    .chip-inactive .chip-dot{background:var(--warning);}

    /* Alerts */
    .alert{
        border-radius:12px;padding:12px 14px;font-weight:700;
        /* Enhanced glass effect */
        background: rgba(255, 255, 255, 0.45);
        backdrop-filter: blur(12px) saturate(180%);
        -webkit-backdrop-filter: blur(12px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
    }
    [data-theme="dark"] .alert {
        background: rgba(15, 23, 42, 0.55);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
    }
    .alert-success{color:#065f46;background:#ecfdf5;border:1px solid #a7f3d0;}
    [data-theme="dark"] .alert-success{color:#bbf7d0;background:rgba(6,95,70,.15);border:1px solid #134e4a;}

    /* Pagination */
    nav .pagination{display:flex;gap:8px;flex-wrap:wrap;padding:12px 0;}
    .page-item{list-style:none;}
    .page-link{
        display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;
        padding:0 12px;border-radius:10px;border:1px solid var(--border);text-decoration:none;
        color:var(--text);background:var(--panel);box-shadow:var(--shadow-1);font-weight:700;
        transition:box-shadow .2s ease, background-color .2s ease, color .2s ease, border-color .2s ease;
        /* Enhanced glass effect */
        background: rgba(255, 255, 255, 0.45);
        backdrop-filter: blur(8px) saturate(180%);
        -webkit-backdrop-filter: blur(8px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
    }
    [data-theme="dark"] .page-link {
        background: rgba(15, 23, 42, 0.55);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
    }
    .page-item.active .page-link{
        background:color-mix(in oklab,var(--accent),#000 8%);color:#fff;border-color:color-mix(in oklab,var(--accent),#000 18%);
        /* Enhanced active state */
        background: rgba(59, 130, 246, 0.75);
        backdrop-filter: blur(8px) saturate(180%);
        -webkit-backdrop-filter: blur(8px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.25);
    }
    [data-theme="dark"] .page-item.active .page-link {
        background: rgba(96, 165, 250, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.25);
    }
    .page-link:hover{
        box-shadow:var(--shadow-2);
        /* Enhanced hover effect */
        background: rgba(255, 255, 255, 0.65);
    }
    [data-theme="dark"] .page-link:hover {
        background: rgba(15, 23, 42, 0.75);
    }

    /* ====== Glossy pill buttons ====== */
    .btn{
        --fg:var(--text); --bd:var(--ring); --fill:color-mix(in oklab,var(--panel),transparent 10%);
        --shine:linear-gradient(115deg,transparent 0%,rgba(255,255,255,.16) 45%,rgba(255,255,255,.28) 55%,transparent 70%);
        position:relative;isolation:isolate;appearance:none;cursor:pointer;
        font-weight:800;letter-spacing:.3px;font-size:14px;border-radius:999px;padding:10px 16px;
        text-decoration:none;display:inline-flex;align-items:center;gap:8px;

        background-image:
          var(--shine),
          linear-gradient(var(--fill),var(--fill)),
          linear-gradient(135deg,var(--bd),color-mix(in oklab,var(--bd),#000 12%));
        background-origin:padding-box,padding-box,border-box;
        background-clip:padding-box,padding-box,border-box;
        background-size:220% 100%,100% 100%,100% 100%;
        background-position:-120% 0,0 0,0 0;

        border:1.5px solid transparent;color:var(--fg);
        box-shadow:var(--shadow-1);
        transition:background-position .6s ease,box-shadow .25s ease,color .25s ease,border-color .25s ease;
        overflow:hidden;backface-visibility:hidden;transform:translateZ(0);
        /* Enhanced glass effect for buttons */
        backdrop-filter: blur(6px) saturate(180%);
        -webkit-backdrop-filter: blur(6px) saturate(180%);
    }
    .btn:hover{background-position:120% 0,0 0,0 0;box-shadow:var(--shadow-2);}
    .btn:active{transform:translateY(1px);}
    .btn:focus-visible{outline:none;box-shadow:0 0 0 3px color-mix(in oklab,var(--accent),transparent 60%),var(--shadow-2);}

    [data-theme="dark"] .btn{
        --shine:linear-gradient(115deg,transparent 0%,rgba(255,255,255,.08) 45%,rgba(255,255,255,.14) 55%,transparent 70%);
        --fill:color-mix(in oklab,var(--panel),transparent 14%);
        color:color-mix(in oklab,var(--text),white 14%);
    }
    .btn-primary{
        --fg:color-mix(in oklab,var(--accent),#000 35%);
        --bd:color-mix(in oklab,var(--accent),#000 15%);
        --fill:color-mix(in oklab,var(--panel),transparent 0%);
    }
    .btn-primary:hover{
        color:#fff;text-shadow:0 1px 0 rgba(0,0,0,.25);
        background-image:
          var(--shine),
          linear-gradient(180deg,color-mix(in oklab,var(--accent),#000 10%),var(--accent)),
          linear-gradient(135deg,color-mix(in oklab,var(--accent),#000 15%),color-mix(in oklab,var(--accent),#000 26%));
        border-color:transparent;
    }
    .btn-ghost{
        --fg:color-mix(in oklab,var(--accent),#000 15%);
        --bd:color-mix(in oklab,var(--accent),#000 20%);
        --fill:color-mix(in oklab,var(--panel),transparent 8%);
        border:1.5px dashed transparent;
        /* Enhanced glass effect */
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(6px) saturate(180%);
        -webkit-backdrop-filter: blur(6px) saturate(180%);
        border: 1.5px dashed rgba(255, 255, 255, 0.18);
    }
    [data-theme="dark"] .btn-ghost {
        background: rgba(15, 23, 42, 0.35);
        border: 1.5px dashed rgba(255, 255, 255, 0.1);
    }
    .btn-ghost:hover{
        border-style:solid;
        color:color-mix(in oklab,var(--accent),#000 10%);
        background-image:
          var(--shine),
          linear-gradient(color-mix(in oklab,var(--accent),transparent 92%),color-mix(in oklab,var(--accent),transparent 92%)),
          linear-gradient(135deg,color-mix(in oklab,var(--accent),#000 20%),color-mix(in oklab,var(--accent),#000 32%));
        /* Enhanced hover effect */
        background: rgba(255, 255, 255, 0.45);
    }
    [data-theme="dark"] .btn-ghost:hover {
        background: rgba(15, 23, 42, 0.55);
        border: 1.5px solid rgba(255, 255, 255, 0.25);
    }
    .btn-danger{
        --fg:color-mix(in oklab,var(--danger),#000 25%);
        --bd:color-mix(in oklab,var(--danger),#000 18%);
        --fill:color-mix(in oklab,var(--panel),transparent 0%);
    }
    .btn-danger:hover{
        color:#fff;text-shadow:0 1px 0 rgba(0,0,0,.25);
        background-image:
          var(--shine),
          linear-gradient(180deg,color-mix(in oklab,var(--danger),#000 8%),var(--danger)),
          linear-gradient(135deg,color-mix(in oklab,var(--danger),#000 18%),color-mix(in oklab,var(--danger),#000 28%));
        box-shadow:0 14px 30px rgba(239,68,68,.35);
        border-color:transparent;
    }

    /* Special utility button (Theme toggle) */
    .btn-tool{
        padding:8px 14px;
        font-size:13px;
    }

    /* Action buttons container */
    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
</style>

<div class="shell">
    <div class="page-header">
        <div>
            <div class="breadcrumbs"><a href="{{ route('admin.packages.index') }}">Packages</a> / <span>Manage</span></div>
            <h1 class="title">Manage Packages</h1>
        </div>
        <div class="actions">
            <button type="button" id="themeToggle" class="btn btn-tool">Theme</button>
            <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">Add New Package</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="panel">
        <div class="panel-header">All Packages</div>
        <div class="panel-body">
            <div class="table-wrap">
                <table class="data">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Days</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th style="min-width:240px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($packages as $package)
                            @php $active = strtolower((string)$package->status) === 'active'; @endphp
                            <tr>
                                <td style="font-weight:800;">{{ $package->package_name }}</td>
                                <td>{{ $package->days }}</td>
                                <td>{{ $package->package_type }}</td>
                                <td>{{ $package->price ? number_format($package->price,2) : 'N/A' }}</td>
                                <td>
                                    @if($active)
                                        <span class="chip chip-active"><span class="chip-dot"></span>Active</span>
                                    @else
                                        <span class="chip chip-inactive"><span class="chip-dot"></span>{{ ucfirst($package->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.packages.show', $package) }}" class="btn btn-ghost">View</a>
                                        <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this package?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6">No packages found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top:12px;">
                {{ $packages->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    // Theme toggle (persist)
    (function(){
        const key='ui-theme';
        const root=document.documentElement;
        const btn=document.getElementById('themeToggle');
        const saved=localStorage.getItem(key);
        if(saved==='dark'){ root.setAttribute('data-theme','dark'); }
        btn?.addEventListener('click', ()=>{
            const dark=root.getAttribute('data-theme')==='dark';
            root.setAttribute('data-theme', dark ? 'light' : 'dark');
            localStorage.setItem(key, dark ? 'light' : 'dark');
        });
        if(!saved && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches){
            root.setAttribute('data-theme','dark');
        }
    })();
</script>
@endsection
