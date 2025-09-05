@extends('admin.layouts.master')

@section('content')
<style>
/* ====== Design Tokens (Light / Dark) ====== */
:root{
  --bg:#f8fafc;
  --panel:#ffffff;
  --muted:#64748b;
  --text:#0f172a;
  --border:#e2e8f0;
  --ring:#cbd5e1;
  --accent:#3b82f6;
  --accent-2:#22c55e;
  --danger:#ef4444;
  --radius:16px;
  --shadow-1:0 10px 20px rgba(2,6,23,.06);
  --shadow-2:0 18px 40px rgba(2,6,23,.10);
  --glass: blur(10px) saturate(1.05);
}
[data-theme="dark"]{
  --bg:#0b1220;
  --panel:#0f172a;
  --muted:#94a3b8;
  --text:#e5e7eb;
  --border:#1f2937;
  --ring:#334155;
  --accent:#60a5fa;
  --accent-2:#34d399;
  --danger:#f87171;
  --shadow-1:0 10px 22px rgba(0,0,0,.35);
  --shadow-2:0 22px 50px rgba(0,0,0,.45);
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

/* ====== Buttons (glossy pill) ====== */
.btn{
  --fg:var(--text);
  --bd:var(--ring);
  --fill:color-mix(in oklab, var(--panel), transparent 8%);
  --shine:linear-gradient(115deg,transparent 0%,rgba(255,255,255,.16) 45%,rgba(255,255,255,.28) 55%,transparent 70%);
  position:relative; isolation:isolate;
  display:inline-flex; align-items:center; justify-content:center; gap:8px;
  padding:10px 16px; border-radius:999px; border:1.5px solid transparent;
  font-weight:800; letter-spacing:.3px; font-size:14px; text-decoration:none; cursor:pointer;
  background-image:var(--shine),
    linear-gradient(var(--fill),var(--fill)),
    linear-gradient(135deg,var(--bd), color-mix(in oklab, var(--bd), #000 12%));
  background-origin:padding-box,padding-box,border-box;
  background-clip:padding-box,padding-box,border-box;
  background-size:220% 100%,100% 100%,100% 100%;
  background-position:-120% 0,0 0,0 0;
  color:var(--fg); box-shadow:var(--shadow-1);
  transition:background-position .6s ease, box-shadow .25s ease, color .25s ease;
}
.btn:hover{ background-position:120% 0,0 0,0 0; box-shadow:var(--shadow-2); }
.btn:active{ transform:translateY(1px); }
.btn:focus-visible{ outline:none; box-shadow:0 0 0 3px color-mix(in oklab, var(--accent), transparent 60%), var(--shadow-2); }

.btn-primary{
  --fg: color-mix(in oklab, var(--accent), #000 35%);
  --bd: color-mix(in oklab, var(--accent), #000 15%);
  --fill: color-mix(in oklab, var(--panel), transparent 0%);
}
.btn-primary:hover{
  color:#fff; text-shadow:0 1px 0 rgba(0,0,0,.25);
  background-image:var(--shine),
    linear-gradient(180deg, color-mix(in oklab, var(--accent), #000 10%), var(--accent)),
    linear-gradient(135deg, color-mix(in oklab, var(--accent), #000 18%), color-mix(in oklab, var(--accent), #000 28%));
}
.btn-neutral{
  --fg: var(--muted);
  --bd: var(--ring);
  --fill: color-mix(in oklab, var(--panel), transparent 12%);
  backdrop-filter: var(--glass);
}
.btn-neutral:hover{ --fill: color-mix(in oklab, var(--panel), transparent 0%); color:var(--text); }

/* ====== Tiles ====== */
.tiles{ display:grid; gap:16px; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); }
.tile{
  border:1px solid var(--border); border-radius:18px; background:var(--panel); box-shadow:var(--shadow-1);
  padding:18px 16px; text-align:center; position:relative; overflow:hidden; transition:transform .12s ease, box-shadow .25s ease;
}
.tile::before{
  content:""; position:absolute; inset:0;
  background: radial-gradient(140% 80% at 50% -10%, rgba(59,130,246,.12), transparent 40%);
  pointer-events:none;
}
.tile:hover{ transform: translateY(-2px); box-shadow: var(--shadow-2); }

.icon{
  width:64px; height:64px; margin:6px auto 12px; border-radius:16px; display:grid; place-items:center;
  background: color-mix(in oklab, var(--panel), transparent 8%);
  border:1px solid color-mix(in oklab, var(--accent), #000 20%);
  color: color-mix(in oklab, var(--accent), #000 20%);
}
.icon i{ font-size:26px; }
.tile h5{ margin:0 0 12px; font-size:18px; font-weight:900; }
</style>

<div class="shell" id="ui-mgmt-root">
  <div class="page-header">
    <div>
      <div class="breadcrumbs">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a> / <span>UI Management</span>
      </div>
      <h1 class="title">UI Management</h1>
    </div>
    <div class="actions">
      <button class="btn btn-neutral" id="themeToggle" type="button">Theme</button>
    </div>
  </div>

  <div class="tiles">
    <div class="tile">
      <div class="icon"><i class="fas fa-image"></i></div>
      <h5>Slider Management</h5>
      <a href="{{ route('admin.sliders.index') }}" class="btn btn-primary">Manage Slider</a>
    </div>

    <div class="tile">
      <div class="icon"><i class="fas fa-cogs"></i></div>
      <h5>Footer Management</h5>
      <a href="{{ route('admin.sliders.index') }}" class="btn btn-primary">Manage Footer</a>
    </div>

    <div class="tile">
      <div class="icon"><i class="fas fa-address-book"></i></div>
      <h5>Contact Us Management</h5>
      <a href="{{ route('admin.sliders.index') }}" class="btn btn-primary">Manage Contact</a>
    </div>

    <div class="tile">
      <div class="icon"><i class="fas fa-info-circle"></i></div>
      <h5>About Us Management</h5>
      <a href="{{ route('admin.sliders.index') }}" class="btn btn-primary">Manage About</a>
    </div>
  </div>
</div>

<script>
  // Theme toggle: persist preference
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
