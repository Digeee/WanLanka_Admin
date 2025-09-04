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
        display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:16px;
        background: linear-gradient(180deg, color-mix(in oklab, var(--panel), transparent 4%), transparent);
        border:1px solid var(--border); border-radius:16px; padding:12px 16px; box-shadow: var(--shadow-1);
    }
    .breadcrumbs{ font-size:12px; color:var(--muted); }
    .breadcrumbs a{ color:inherit; text-decoration:none; }
    .title{ margin:0; font-size:26px; font-weight:800; letter-spacing:.2px; }
    .actions{ display:flex; gap:10px; flex-wrap:wrap; }

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

        /* 1) moving shine  2) inner fill  3) gradient border */
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
        overflow:hidden;                  /* clip shine */
        backface-visibility:hidden; transform:translateZ(0);
    }
    .btn:hover{
        background-position: 120% 0, 0 0, 0 0;    /* sweep shine */
        box-shadow: var(--shadow-2);
    }
    .btn:active{ transform: translateY(1px); }
    .btn:focus-visible{
        outline:none;
        box-shadow: 0 0 0 3px color-mix(in oklab, var(--accent), transparent 60%), var(--shadow-2);
    }

    /* Dark theme tuning: reduce glare & boost contrast */
    [data-theme="dark"] .btn{
        --shine: linear-gradient(115deg, transparent 0%, rgba(255,255,255,.08) 45%, rgba(255,255,255,.14) 55%, transparent 70%);
        --fill: color-mix(in oklab, var(--panel), transparent 12%);
        color: color-mix(in oklab, var(--text), white 12%); /* slightly brighter labels by default */
    }

    /* --- Primary (Add / Edit / Theme) --- */
    .btn-primary{
        /* Light theme default label (darker for readability) */
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
    /* Primary in DARK: brighter label & border even before hover */
    [data-theme="dark"] .btn-primary{
        --fg: color-mix(in oklab, var(--accent), white 45%);
        --bd: color-mix(in oklab, var(--accent), white 18%);
        --fill: color-mix(in oklab, var(--panel), transparent 10%);
    }
    [data-theme="dark"] .btn-primary:hover{
        /* keep same hover fill but slightly deeper for dark */
        background-image:
          var(--shine),
          linear-gradient(180deg, color-mix(in oklab, var(--accent), #000 16%), color-mix(in oklab, var(--accent), #000 2%)),
          linear-gradient(135deg, color-mix(in oklab, var(--accent), #000 26%), color-mix(in oklab, var(--accent), #000 36%));
    }

    /* --- Ghost (unused here, kept for consistency) --- */
    .btn-ghost{
        --fg: color-mix(in oklab, var(--accent), #000 15%);
        --bd: color-mix(in oklab, var(--accent), #000 20%);
        --fill: color-mix(in oklab, var(--panel), transparent 8%);
        border:1.5px dashed transparent;
    }
    .btn-ghost:hover{
        border-style: solid;
        color: color-mix(in oklab, var(--accent), #000 10%);
        background-image:
          var(--shine),
          linear-gradient(color-mix(in oklab, var(--accent), transparent 92%), color-mix(in oklab, var(--accent), transparent 92%)),
          linear-gradient(135deg, color-mix(in oklab, var(--accent), #000 20%), color-mix(in oklab, var(--accent), #000 32%));
    }
    [data-theme="dark"] .btn-ghost{
        --fg: color-mix(in oklab, var(--accent), white 40%);
        --bd: color-mix(in oklab, var(--accent), white 22%);
        --fill: color-mix(in oklab, var(--panel), transparent 10%);
    }

    /* --- Danger (Delete) --- */
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
    [data-theme="dark"] .btn-danger:hover{
        background-image:
          var(--shine),
          linear-gradient(180deg, color-mix(in oklab, var(--danger), #000 18%), color-mix(in oklab, var(--danger), #000 4%)),
          linear-gradient(135deg, color-mix(in oklab, var(--danger), #000 28%), color-mix(in oklab, var(--danger), #000 38%));
    }

    /* Panel */
    .panel{ background:var(--panel); border:1px solid var(--border); border-radius:var(--radius); box-shadow:var(--shadow-1); overflow:hidden; }
    .panel-header{ padding:14px 16px; border-bottom:1px solid var(--border); font-weight:800; }
    .panel-body{ padding:16px; }

    /* Alerts */
    .alert{ border-radius:12px; padding:12px 14px; font-weight:700; }
    .alert-success{ color:#065f46; background:#ecfdf5; border:1px solid #a7f3d0; }
    [data-theme="dark"] .alert-success{ color:#bbf7d0; background:rgba(6,95,70,.15); border:1px solid #134e4a; }

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

    /* Name cell with avatar */
    .identity{ display:flex; align-items:center; gap:10px; }
    .avatar{
        width:36px; height:36px; border-radius:10px; overflow:hidden; border:1px solid var(--border);
        background: linear-gradient(135deg, color-mix(in oklab, var(--accent), transparent 70%), color-mix(in oklab, var(--panel), transparent 30%));
        display:grid; place-items:center; color:#fff; font-weight:800; font-size:12px;
        flex: 0 0 auto;
    }
    .avatar img{ width:100%; height:100%; object-fit:cover; display:block; }

    /* Chips for status */
    .chip{ display:inline-flex; align-items:center; gap:8px; height:28px; padding:0 12px; border-radius:999px;
           border:1px solid var(--ring); font-size:12px; font-weight:800; color:var(--text);
           background: color-mix(in oklab, var(--panel), transparent 8%); }
    .chip-dot{ width:8px; height:8px; border-radius:999px; }
    .chip-active{ color: var(--accent); border-color: color-mix(in oklab, var(--accent), #000 15%); }
    .chip-inactive{ color: var(--warning); border-color: var(--warning); }
    .chip-active .chip-dot{ background: var(--accent-2); }
    .chip-inactive .chip-dot{ background: var(--warning); }

    /* Pagination */
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

    /* Dark header contrast */
    [data-theme="dark"] .page-header{ background: linear-gradient(180deg, #0f172a, #0b1220); border:1px solid var(--ring); }

    /* Avatar initials visibility (light theme) */
    :root .avatar{
      background: linear-gradient(135deg, color-mix(in oklab, var(--accent), white 70%), #eef2ff);
      border-color: #dbeafe;
    }
    :root .avatar > span{ color:#0f172a !important; text-shadow:0 1px 0 rgba(255,255,255,.55); }
    [data-theme="dark"] .avatar{
      background: linear-gradient(135deg, color-mix(in oklab, var(--accent), transparent 70%), color-mix(in oklab, var(--panel), transparent 30%));
    }
    [data-theme="dark"] .avatar > span{ color:#fff !important; }
</style>

<div class="shell" id="guider-index-root">
    <div class="page-header">
        <div>
            <div class="breadcrumbs">
                <a href="{{ route('admin.guiders.index') }}">Guiders</a> / <span>Manage</span>
            </div>
            <h1 class="title">Manage Guiders</h1>
        </div>
        <div class="actions">
            <button class="btn btn-primary" id="themeToggle" type="button">Theme</button>
            <a href="{{ route('admin.guiders.create') }}" class="btn btn-primary">Add New Guider</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="panel">
        <div class="panel-header">All Guiders</div>
        <div class="panel-body">
            <div class="table-wrap">
                <table class="data">
                    <thead>
                    <tr>
                        <th style="min-width:260px;">Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th style="min-width:240px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($guiders as $guider)
                        @php
                            $status = strtolower((string) $guider->status);
                            $isActive = in_array($status, ['active','approved','enabled']);
                            $initials = strtoupper(substr($guider->first_name,0,1).substr($guider->last_name,0,1));
                        @endphp
                        <tr>
                            <td>
                                <div class="identity">
                                    <div class="avatar">
                                        @if(property_exists($guider,'image') && $guider->image)
                                            <img src="{{ asset('storage/' . $guider->image) }}" alt="Avatar"
                                                 onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                                        @else
                                            <span>{{ $initials }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div style="font-weight:800;">{{ $guider->first_name }} {{ $guider->last_name }}</div>
                                        <div style="font-size:12px; color:var(--muted);">{{ $guider->city ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-weight:800;">{{ $guider->email }}</td>
                            <td style="font-weight:800;">{{ $guider->phone ?? 'N/A' }}</td>
                            <td>
                                @if($isActive)
                                    <span class="chip chip-active"><span class="chip-dot"></span>Active</span>
                                @else
                                    <span class="chip chip-inactive"><span class="chip-dot"></span>{{ ucfirst($guider->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.guiders.show', $guider) }}" class="btn btn-primary">View</a>
                                    <a href="{{ route('admin.guiders.edit', $guider) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('admin.guiders.destroy', $guider) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this guider?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top:12px;">
                {{ $guiders->links() }}
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
</script>
@endsection
