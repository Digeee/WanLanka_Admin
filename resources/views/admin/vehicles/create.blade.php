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
        --glass: blur(10px) saturate(1.05);
    }
    [data-theme="dark"]{
        --bg:#0b1220; --panel:#0f172a; --muted:#94a3b8; --text:#e5e7eb;
        --border:#1f2937; --ring:#334155; --accent:#60a5fa; --accent-2:#34d399;
        --danger:#f87171; --warning:#fbbf24;
        --shadow-1:0 10px 22px rgba(0,0,0,.35);
        --shadow-2:0 22px 50px rgba(0,0,0,.45);
        --glass: blur(10px) saturate(1.05);
    }

    /* ====== Shell & Header ====== */
    .shell{max-width:1100px;margin:28px auto 80px;padding:0 20px;color:var(--text);}
    body{
        background:
           radial-gradient(1200px 600px at 10% -10%, color-mix(in oklab, var(--accent), transparent 94%), transparent),
           var(--bg);
    }
    .page-header{
        display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:18px;
        background:linear-gradient(180deg,color-mix(in oklab,var(--panel),transparent 4%),transparent);
        border:1px solid var(--border);border-radius:18px;padding:14px 18px;box-shadow:var(--shadow-1);
        overflow:hidden;
    }
    [data-theme="dark"] .page-header{
        background:
          radial-gradient(1200px 150px at 10% -40%, rgba(59,130,246,.12), transparent 70%),
          linear-gradient(180deg,#0f172a 0%, #0b1220 100%);
        border:1px solid var(--ring);
        box-shadow:0 18px 50px rgba(2,6,23,.55), inset 0 1px 0 rgba(255,255,255,.04);
    }
    .breadcrumbs{font-size:12px;color:var(--muted);}
    .breadcrumbs a{color:inherit;text-decoration:none;}
    .title{margin:0;font-size:28px;font-weight:800;letter-spacing:.2px;color:var(--text);}
    [data-theme="dark"] .title{color:#f8fafc;text-shadow:0 1px 0 rgba(0,0,0,.45);}
    .actions{display:flex;gap:12px;flex-wrap:wrap;}

    /* ====== Panels ====== */
    .panel{background:var(--panel);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-1);overflow:hidden;}
    .panel-header{
        padding:14px 16px;border-bottom:1px solid var(--border);font-weight:800;
        background:
          linear-gradient(180deg,color-mix(in oklab,var(--panel),transparent 92%),transparent),
          radial-gradient(1000px 100px at 0 -30%,color-mix(in oklab,var(--accent),transparent 92%),transparent);
    }
    .panel-body{padding:18px;}

    /* ====== Form ====== */
    .form-grid{display:grid;gap:14px;grid-template-columns:1fr;}
    @media (min-width:820px){.form-grid.split{grid-template-columns:1fr 1fr;}}
    label{font-weight:700;font-size:13px;color:var(--muted);margin-bottom:6px;display:block;}
    .field{
        background:color-mix(in oklab,var(--panel),transparent 0%);
        border:1px solid var(--border);border-radius:12px;padding:12px 14px;color:var(--text);width:100%;
        transition:border-color .18s ease,box-shadow .18s ease,background-color .18s ease;
    }
    .field:focus{
        outline:none;border-color:color-mix(in oklab,var(--accent),#000 10%);
        box-shadow:0 0 0 3px color-mix(in oklab,var(--accent),transparent 80%);
        background:color-mix(in oklab,var(--panel),transparent 2%);
    }
    textarea.field{min-height:110px;resize:vertical;line-height:1.5;}
    input[type="file"].field{padding:10px;}

    /* ====== Alerts ====== */
    .alert{border-radius:12px;padding:12px 14px;font-weight:700;}
    .alert-danger{color:#7f1d1d;background:#fee2e2;border:1px solid #fecaca;}
    [data-theme="dark"] .alert-danger{color:#fecaca;background:rgba(127,29,29,.2);border:1px solid #7f1d1d;}

    /* ====== Glossy-pill Buttons (no-shake) ====== */
    .btn{
        --fg:var(--text); --bd:var(--ring); --fill:color-mix(in oklab,var(--panel),transparent 10%);
        --shine:linear-gradient(115deg,transparent 0%,rgba(255,255,255,.16) 45%,rgba(255,255,255,.28) 55%,transparent 70%);
        position:relative;isolation:isolate;appearance:none;cursor:pointer;
        font-weight:800;letter-spacing:.3px;font-size:14px;border-radius:999px;padding:12px 18px;
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
    .btn-neutral{
        --fg:color-mix(in oklab,var(--muted),#000 10%);
        --bd:var(--ring);
        --fill:color-mix(in oklab,var(--panel),transparent 12%);
        backdrop-filter:var(--glass);
    }
    .btn-neutral:hover{--fill:color-mix(in oklab,var(--panel),transparent 0%);--fg:var(--text);}
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
</style>

<div class="shell">
    <div class="page-header">
        <div>
            <div class="breadcrumbs"><a href="{{ route('admin.vehicles.index') }}">Vehicles</a> / <span>Add</span></div>
            <h1 class="title">Add New Vehicle</h1>
        </div>
        <div class="actions">
            <button type="button" id="themeToggle" class="btn btn-primary">Theme</button>
            <a href="{{ route('admin.vehicles.index') }}" class="btn btn-primary">Back</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0;padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel">
        <div class="panel-header">Vehicle Information</div>
        <div class="panel-body">
            <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-grid split">
                    <div>
                        <label for="vehicle_type">Vehicle Type</label>
                        <select name="vehicle_type" id="vehicle_type" class="field" required>
                            <option value="bike"           {{ old('vehicle_type') == 'bike' ? 'selected' : '' }}>Bike</option>
                            <option value="three_wheeler" {{ old('vehicle_type') == 'three_wheeler' ? 'selected' : '' }}>Three Wheeler</option>
                            <option value="car"            {{ old('vehicle_type') == 'car' ? 'selected' : '' }}>Car</option>
                            <option value="van"            {{ old('vehicle_type') == 'van' ? 'selected' : '' }}>Van</option>
                            <option value="bus"            {{ old('vehicle_type') == 'bus' ? 'selected' : '' }}>Bus</option>
                        </select>
                    </div>
                    <div>
                        <label for="number_plate">Number Plate</label>
                        <input type="text" name="number_plate" id="number_plate" class="field" value="{{ old('number_plate') }}" required>
                    </div>
                </div>

                <div class="form-grid split">
                    <div>
                        <label for="photo">Photo</label>
                        <input type="file" name="photo" id="photo" class="field">
                    </div>
                    <div>
                        <label for="seat_count">Seat Count</label>
                        <input type="number" name="seat_count" id="seat_count" class="field" value="{{ old('seat_count', 1) }}" min="1" required>
                    </div>
                </div>

                <div class="form-grid split">
                    <div>
                        <label for="model">Model</label>
                        <input type="text" name="model" id="model" class="field" value="{{ old('model') }}">
                    </div>
                    <div>
                        <label for="year">Year</label>
                        <input type="number" name="year" id="year" class="field" value="{{ old('year') }}" min="1900" max="{{ date('Y') }}">
                    </div>
                </div>

                <div class="form-grid split">
                    <div>
                        <label for="color">Color</label>
                        <input type="text" name="color" id="color" class="field" value="{{ old('color') }}">
                    </div>
                    <div>
                        <label for="status">Status</label>
                        <select name="status" id="status" class="field">
                            <option value="active"   {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="field">{{ old('description') }}</textarea>
                </div>

                <div class="actions" style="margin-top:18px;">
                    <button type="submit" class="btn btn-primary">Save Vehicle</button>
                    <a href="{{ route('admin.vehicles.index') }}" class="btn btn-neutral">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Theme toggle (persist across pages)
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
