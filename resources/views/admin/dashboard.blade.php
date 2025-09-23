@extends('admin.layouts.master')

@section('content')
<style>
    /* ====== Design Tokens (Light / Dark) ====== */
    :root{
        --bg:#f8fafc; --panel:#ffffff; --muted:#64748b; --text:#0f172a;
        --border:#e2e8f0; --ring:#cbd5e1; --accent:#3b82f6; --accent-2:#22c55e;
        --danger:#ef4444; --warning:#f59e0b; --purple:#8b5cf6;
        --radius:16px;
        --shadow-1:0 10px 20px rgba(2,6,23,.06);
        --shadow-2:0 18px 40px rgba(2,6,23,.12);
        --glass: blur(10px) saturate(1.05);
    }
    [data-theme="dark"]{
        --bg:#0b1220; --panel:#0f172a; --muted:#94a3b8; --text:#e5e7eb;
        --border:#1f2937; --ring:#334155; --accent:#60a5fa; --accent-2:#34d399;
        --danger:#f87171; --warning:#fbbf24; --purple:#a78bfa;
        --shadow-1:0 10px 22px rgba(0,0,0,.35);
        --shadow-2:0 22px 50px rgba(0,0,0,.45);
    }

    /* ====== Page Shell ====== */
    .shell{ max-width:1200px; margin:28px auto 80px; padding:0 20px; color:var(--text); }
    body{
        background:
           radial-gradient(1200px 600px at 10% -10%, color-mix(in oklab, var(--accent), transparent 94%), transparent),
           var(--bg);
    }

    /* ====== Header ====== */
    .page-header{
        display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:18px;
        background: linear-gradient(180deg, color-mix(in oklab, var(--panel), transparent 4%), transparent);
        border:1px solid var(--border); border-radius:18px; padding:14px 18px; box-shadow: var(--shadow-1);
        overflow:hidden;
    }
    [data-theme="dark"] .page-header{
        background:
          radial-gradient(1200px 150px at 10% -40%, rgba(59,130,246,.12), transparent 70%),
          linear-gradient(180deg, #0f172a 0%, #0b1220 100%);
        border:1px solid var(--ring);
        box-shadow:0 18px 50px rgba(2,6,23,.55), inset 0 1px 0 rgba(255,255,255,.04);
    }
    .title{ margin:0; font-size:26px; font-weight:800; letter-spacing:.2px; }
    [data-theme="dark"] .title{ color:#f8fafc; text-shadow:0 1px 0 rgba(0,0,0,.45); }
    .breadcrumbs{ font-size:12px; color:var(--muted); }
    .breadcrumbs a{ color:inherit; text-decoration:none; }
    .actions{ display:flex; gap:10px; flex-wrap:wrap; }

    /* ====== Buttons (your unified style) ====== */
    .btn{
        --fg:var(--text); --bd:var(--ring); --fill:color-mix(in oklab,var(--panel),transparent 10%);
        --shine:linear-gradient(115deg,transparent 0%,rgba(255,255,255,.16) 45%,rgba(255,255,255,.28) 55%,transparent 70%);
        position:relative; isolation:isolate; appearance:none; cursor:pointer;
        font-weight:800; letter-spacing:.3px; font-size:14px; border-radius:999px; padding:10px 16px;
        text-decoration:none; display:inline-flex; align-items:center; gap:8px;

        background-image:
          var(--shine),
          linear-gradient(var(--fill),var(--fill)),
          linear-gradient(135deg,var(--bd),color-mix(in oklab,var(--bd),#000 12%));
        background-origin:padding-box,padding-box,border-box;
        background-clip:padding-box,padding-box,border-box;
        background-size:220% 100%,100% 100%,100% 100%;
        background-position:-120% 0,0 0,0 0;

        border:1.5px solid transparent; color:var(--fg);
        box-shadow:var(--shadow-1);
        transition:background-position .6s ease,box-shadow .25s ease,color .25s ease,border-color .25s ease, transform .06s ease;
        overflow:hidden; backface-visibility:hidden; transform:translateZ(0);
    }
    .btn:hover{ background-position:120% 0,0 0,0 0; box-shadow:var(--shadow-2); }
    .btn:active{ transform:translateY(1px); }
    .btn:focus-visible{ outline:none; box-shadow:0 0 0 3px color-mix(in oklab,var(--accent),transparent 60%), var(--shadow-2); }

    .btn-primary{
        --fg:color-mix(in oklab,var(--accent),#000 35%);
        --bd:color-mix(in oklab,var(--accent),#000 15%);
        --fill:color-mix(in oklab,var(--panel),transparent 0%);
    }
    .btn-primary:hover{
        color:#fff; text-shadow:0 1px 0 rgba(0,0,0,.25);
        background-image:
          var(--shine),
          linear-gradient(180deg, color-mix(in oklab,var(--accent),#000 10%), var(--accent)),
          linear-gradient(135deg, color-mix(in oklab,var(--accent),#000 15%), color-mix(in oklab,var(--accent),#000 26%));
        border-color:transparent;
    }
    .btn-neutral{
        --fg: color-mix(in oklab,var(--muted),#000 10%);
        --bd: var(--ring);
        --fill: color-mix(in oklab,var(--panel),transparent 12%);
        backdrop-filter: var(--glass);
    }
    .btn-neutral:hover{ --fill:color-mix(in oklab,var(--panel),transparent 0%); --fg:var(--text); }

    /* ====== Stat Cards ====== */
    .stats{ display:grid; gap:14px; grid-template-columns: 1fr; }
    @media (min-width: 900px){ .stats{ grid-template-columns: repeat(4, minmax(0,1fr)); } }

    .stat{
        position:relative; border:1px solid var(--border); border-radius:18px; padding:16px; overflow:hidden;
        background:
          radial-gradient(220px 120px at 0% 0%, color-mix(in oklab, var(--accent), transparent 88%), transparent 60%),
          var(--panel);
        box-shadow:var(--shadow-1);
        transition:transform .08s ease, box-shadow .25s ease;
    }
    .stat:hover{ transform: translateY(-2px); box-shadow:var(--shadow-2); }
    .stat h3{ margin:0 0 8px; font-size:13px; letter-spacing:.4px; text-transform:uppercase; color:var(--muted); font-weight:800; }
    .stat p{ margin:0; font-size:32px; font-weight:900; letter-spacing:.2px; color:var(--text); }

    /* tinted variants */
    .t-blue{ background:
        radial-gradient(220px 120px at 0% 0%, color-mix(in oklab, var(--accent), transparent 86%), transparent 60%),
        var(--panel); }
    .t-green{ background:
        radial-gradient(220px 120px at 0% 0%, color-mix(in oklab, var(--accent-2), transparent 86%), transparent 60%),
        var(--panel); }
    .t-purple{ background:
        radial-gradient(220px 120px at 0% 0%, color-mix(in oklab, var(--purple), transparent 86%), transparent 60%),
        var(--panel); }
    .t-amber{ background:
        radial-gradient(220px 120px at 0% 0%, color-mix(in oklab, var(--warning), transparent 86%), transparent 60%),
        var(--panel); }

    [data-theme="dark"] .stat{
        border-color: var(--ring);
        background:
          radial-gradient(260px 140px at -10% -30%, rgba(96,165,250,.18), transparent 60%),
          linear-gradient(180deg, #0f172a 0%, #0b1220 100%);
        box-shadow:0 12px 38px rgba(0,0,0,.45), inset 0 1px 0 rgba(255,255,255,.03);
    }
    [data-theme="dark"] .t-green{
        background:
          radial-gradient(260px 140px at -10% -30%, rgba(52,211,153,.18), transparent 60%),
          linear-gradient(180deg, #0f172a 0%, #0b1220 100%);
    }
    [data-theme="dark"] .t-purple{
        background:
          radial-gradient(260px 140px at -10% -30%, rgba(167,139,250,.18), transparent 60%),
          linear-gradient(180deg, #0f172a 0%, #0b1220 100%);
    }
    [data-theme="dark"] .t-amber{
        background:
          radial-gradient(260px 140px at -10% -30%, rgba(251,191,36,.18), transparent 60%),
          linear-gradient(180deg, #0f172a 0%, #0b1220 100%);
    }
</style>

<div class="shell" id="dashboard-root">
    <div class="page-header">
        <div>
            <div class="breadcrumbs">Dashboard</div>
            <h1 class="title">Admin Dashboard</h1>
        </div>
        <div class="actions">
            <button class="btn btn-neutral" type="button" id="themeToggle" aria-label="Toggle theme">Theme</button>
            <a href="{{ route('admin.guiders.create') }}" class="btn btn-primary">Add Guider</a>
        </div>
    </div>

    <div class="stats">
        <div class="stat t-blue">
            <h3>Total Guiders</h3>
            <p>{{ $guiderCount }}</p>
        </div>
        <div class="stat t-purple">
            <h3>Total Vehicles</h3>
            <p>{{ $vehicleCount }}</p>
        </div>
        <div class="stat t-green">
            <h3>Total Accommodations</h3>
            <p>{{ $accommodationCount }}</p>
        </div>
        <div class="stat t-amber">
            <h3>Total Places</h3>
            <p>{{ $placeCount }}</p>
        </div>
        <div class="stat t-green">
            <h3>Total Packages</h3>
            <p>{{ $packageCount }}</p>
        </div>
    </div>
</div>

<script>
    
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
