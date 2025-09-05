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
    --shadow-1: 0 10px 22px rgba(0,0,0,.35);
    --shadow-2: 0 22px 50px rgba(0,0,0,.45);
  }

  /* ====== Page Shell ====== */
  .shell{ max-width: 1000px; margin: 28px auto 80px; padding: 0 20px; color: var(--text); }
  body{
    background:
      radial-gradient(1200px 600px at 10% -10%, color-mix(in oklab, var(--accent), transparent 94%), transparent),
      var(--bg);
  }

  /* Header */
  .page-header{
    display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:18px;
    background: linear-gradient(180deg, color-mix(in oklab, var(--panel), transparent 4%), transparent);
    border:1px solid var(--border); border-radius:16px; padding:12px 16px; box-shadow: var(--shadow-1);
  }
  .breadcrumbs{ font-size:12px; color:var(--muted); }
  .breadcrumbs a{ color:inherit; text-decoration:none; }
  .title{ margin:0; font-size:26px; font-weight:800; letter-spacing:.2px; }
  .actions{ display:flex; gap:10px; flex-wrap:wrap; }

  /* ====== Buttons (gloss + gradient border, consistent sitewide) ====== */
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
    transition: background-position .6s ease, box-shadow .25s ease, color .25s ease, border-color .25s ease, transform .06s ease;
    overflow:hidden;
    backface-visibility:hidden; transform:translateZ(0);
  }
  .btn:hover{ background-position:120% 0,0 0,0 0; box-shadow: var(--shadow-2); }
  .btn:active{ transform: translateY(1px); }
  .btn:focus-visible{ outline:none; box-shadow: 0 0 0 3px color-mix(in oklab, var(--accent), transparent 60%), var(--shadow-2); }

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

  .btn-neutral{
    --fg: color-mix(in oklab, var(--muted), #000 10%);
    --bd: var(--ring);
    --fill: color-mix(in oklab, var(--panel), transparent 12%);
    backdrop-filter: var(--glass);
  }
  .btn-neutral:hover{ --fill: color-mix(in oklab, var(--panel), transparent 0%); --fg: var(--text); }

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

  /* Panels */
  .panel{ background:var(--panel); border:1px solid var(--border); border-radius:var(--radius); box-shadow:var(--shadow-1); overflow:hidden; }
  .panel-header{ padding:14px 16px; border-bottom:1px solid var(--border); font-weight:800; }
  .panel-body{ padding:18px; }

  /* Alerts */
  .alert{ border-radius:12px; padding:12px 14px; font-weight:700; margin-bottom:12px; }
  .alert-danger{ color:#7f1d1d; background:#fee2e2; border:1px solid #fecaca; }
  [data-theme="dark"] .alert-danger{ color:#fecaca; background:rgba(127,29,29,.18); border:1px solid #7f1d1d; }

  /* Form */
  .form-grid{ display:grid; gap:14px; grid-template-columns:1fr; }
  @media (min-width: 820px){ .form-grid{ grid-template-columns: repeat(2,minmax(0,1fr)); } }
  .form-item{ display:flex; flex-direction:column; gap:6px; }
  .form-item.full{ grid-column: 1 / -1; }
  label{ font-size:12px; text-transform:uppercase; letter-spacing:.5px; color:var(--muted); font-weight:800; }
  .form-control, textarea{
    width:100%; padding:12px 14px; border-radius:12px; border:1px solid var(--border);
    background: color-mix(in oklab, var(--panel), transparent 4%); color: var(--text); font-weight:700;
    transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
  }
  .form-control:focus, textarea:focus{
    outline:none; border-color: color-mix(in oklab, var(--accent), #000 22%);
    box-shadow: 0 0 0 3px color-mix(in oklab, var(--accent), transparent 75%);
    background: color-mix(in oklab, var(--panel), transparent 0%);
  }
  input[type="file"]{
    border:1px dashed var(--ring); padding:12px; border-radius:12px; background: color-mix(in oklab, var(--panel), transparent 6%);
  }

  /* Preview */
  .preview{
    display:flex; align-items:center; gap:12px; margin-top:8px; flex-wrap:wrap;
  }
  .preview img{
    width:140px; height:90px; object-fit:cover; border-radius:12px; border:1px solid var(--border);
    background: #fff;
  }

  /* Footer actions */
  .form-actions{ display:flex; gap:10px; flex-wrap:wrap; margin-top:8px; }
</style>

<div class="shell" id="slider-create-root">
  <div class="page-header">
    <div>
      <div class="breadcrumbs">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a> / <a href="{{ route('admin.sliders.index') }}">Sliders</a> / <span>Create</span>
      </div>
      <h1 class="title">Create New Slider</h1>
    </div>
    <div class="actions">
      <button class="btn btn-neutral" id="themeToggle" type="button">Theme</button>
      <a href="{{ route('admin.sliders.index') }}" class="btn btn-neutral">Back</a>
    </div>
  </div>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul style="margin:0 0 0 18px;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="panel">
    <div class="panel-header">Slider Info</div>
    <div class="panel-body">
      <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">
          <div class="form-item full">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control" required>
            <div class="preview" id="imgPreviewWrap" style="display:none;">
              <img id="imgPreview" alt="Preview">
            </div>
          </div>

          <div class="form-item">
            <label for="caption">Caption</label>
            <input type="text" name="caption" id="caption" class="form-control" required>
          </div>

          <div class="form-item">
            <label for="button_name">Button Name</label>
            <input type="text" name="button_name" id="button_name" class="form-control" required>
          </div>

          <div class="form-item full">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
          </div>

          <div class="form-item full">
            <label for="button_link">Button Link</label>
            <input type="url" name="button_link" id="button_link" class="form-control" placeholder="https://example.com" required>
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Save</button>
          <a href="{{ route('admin.sliders.index') }}" class="btn btn-neutral">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Theme toggle (persisted)
  (function(){
    const key='ui-theme';
    const root=document.documentElement;
    const btn=document.getElementById('themeToggle');
    const saved=localStorage.getItem(key);
    if(saved==='dark'){ root.setAttribute('data-theme','dark'); }
    btn?.addEventListener('click', ()=>{
      const dark=root.getAttribute('data-theme')==='dark';
      root.setAttribute('data-theme', dark?'light':'dark');
      localStorage.setItem(key, dark?'light':'dark');
    });
    if(!saved && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches){
      root.setAttribute('data-theme','dark');
    }
  })();

  // Image preview
  (function(){
    const input = document.getElementById('image');
    const wrap = document.getElementById('imgPreviewWrap');
    const img  = document.getElementById('imgPreview');
    input?.addEventListener('change', (e)=>{
      const f = e.target.files?.[0];
      if(!f) { wrap.style.display='none'; img.src=''; return; }
      const url = URL.createObjectURL(f);
      img.src = url;
      wrap.style.display='flex';
    });
  })();
</script>
@endsection
