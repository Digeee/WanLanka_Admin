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

    /* ====== Page Shell ====== */
    .shell{max-width:1100px;margin:28px auto 80px;padding:0 20px;color:var(--text);}
    body{
        background:
           radial-gradient(1200px 600px at 10% -10%, color-mix(in oklab, var(--accent), transparent 94%), transparent),
           var(--bg);
    }

    /* ====== Header ====== */
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
    .title{margin:0;font-size:26px;font-weight:800;letter-spacing:.2px;}
    [data-theme="dark"] .title{color:#f8fafc;text-shadow:0 1px 0 rgba(0,0,0,.45);}
    .sub{color:var(--muted);font-weight:700;font-size:12px;}
    .actions{display:flex;gap:10px;flex-wrap:wrap;}

    /* ====== Panels / Cards ====== */
    .panel{background:var(--panel);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-1);overflow:hidden;}
    .panel-header{
        padding:14px 16px;border-bottom:1px solid var(--border);font-weight:800;
        background:
          linear-gradient(180deg,color-mix(in oklab,var(--panel),transparent 92%),transparent),
          radial-gradient(1000px 100px at 0 -30%,color-mix(in oklab,var(--accent),transparent 92%),transparent);
    }
    .panel-body{padding:18px;}
    .layout{display:grid;gap:16px;grid-template-columns:1fr;}
    @media(min-width:900px){ .layout{grid-template-columns:1.2fr .8fr;} }

    /* ====== Key-Value grid ====== */
    .kv-grid{display:grid;gap:12px;grid-template-columns:1fr;}
    @media(min-width:650px){ .kv-grid{grid-template-columns:repeat(2,minmax(0,1fr));} }
    .kv{border:1px solid var(--border);border-radius:12px;padding:12px 14px;background:color-mix(in oklab,var(--panel),transparent 6%);}
    .kv .label{font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--muted);margin-bottom:6px;}
    .kv .value{font-weight:800;word-break:break-word;}
    .desc{grid-column:1/-1;border:1px dashed var(--ring);border-radius:12px;padding:14px;line-height:1.6;background:color-mix(in oklab,var(--panel),transparent 4%);}

    /* ====== Media ====== */
    .media-card{border:1px solid var(--border);border-radius:12px;padding:12px;background:color-mix(in oklab,var(--panel),transparent 6%);}
    .media-card h6{margin:0 0 8px;font-size:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;}
    .media-card img{width:100%;aspect-ratio:16/10;object-fit:cover;border-radius:10px;display:block;}

    /* ====== Chips ====== */
    .chip{display:inline-flex;align-items:center;gap:8px;height:28px;padding:0 12px;border-radius:999px;border:1px solid var(--ring);font-size:12px;font-weight:800;color:var(--text);background:color-mix(in oklab,var(--panel),transparent 8%);}
    .chip-dot{width:8px;height:8px;border-radius:999px;}
    .chip-active{color:var(--accent);border-color:color-mix(in oklab,var(--accent),#000 15%);}
    .chip-inactive{color:var(--warning);border-color:var(--warning);}
    .chip-active .chip-dot{background:var(--accent-2);}
    .chip-inactive .chip-dot{background:var(--warning);}

    /* ====== Buttons (glossy pill, stable hover) ====== */
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
    .btn-neutral{
        --fg:color-mix(in oklab,var(--muted),#000 10%);
        --bd:var(--ring);
        --fill:color-mix(in oklab,var(--panel),transparent 12%);
        backdrop-filter:var(--glass);
    }
    .btn-neutral:hover{--fill:color-mix(in oklab,var(--panel),transparent 0%);--fg:var(--text);}

    /* ====== Chips bar ====== */
    .chip-row{display:flex;gap:10px;flex-wrap:wrap;}
</style>

<div class="shell">
    <!-- Header -->
    <div class="page-header">
        <div>
            <div class="breadcrumbs"><a href="{{ route('admin.vehicles.index') }}">Vehicles</a> / <span>Details</span></div>
            <h1 class="title">{{ ucfirst(str_replace('_',' ', $vehicle->vehicle_type)) }} — {{ $vehicle->number_plate }}</h1>
            <div class="sub">{{ $vehicle->model ?? '—' }} {{ $vehicle->year ? '· '.$vehicle->year : '' }}</div>
        </div>
        <div class="actions">
            <button type="button" id="themeToggle" class="btn btn-primary">Theme</button>
            <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this vehicle?')">Delete</button>
            </form>
            <a href="{{ route('admin.vehicles.index') }}" class="btn btn-neutral">Back to List</a>
        </div>
    </div>

    <!-- Status / Quick chips -->
    <div class="panel" style="margin-bottom:14px;">
        <div class="panel-header">
            <div class="chip-row">
                @php
                    $isActive = strtolower((string)$vehicle->status) === 'active';
                @endphp
                @if($isActive)
                    <span class="chip chip-active"><span class="chip-dot"></span>Active</span>
                @else
                    <span class="chip chip-inactive"><span class="chip-dot"></span>{{ ucfirst($vehicle->status) }}</span>
                @endif
                <span class="chip" title="Seats"><span class="chip-dot" style="background:var(--ring)"></span>{{ $vehicle->seat_count }} seats</span>
                @if($vehicle->color)
                    <span class="chip" title="Color"><span class="chip-dot" style="background:{{ $vehicle->color }}"></span>{{ $vehicle->color }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Main layout -->
    <div class="layout">
        <!-- Left: profile -->
        <div class="panel">
            <div class="panel-header"><strong>Vehicle Profile</strong></div>
            <div class="panel-body">
                <div class="kv-grid">
                    <div class="kv">
                        <div class="label">Vehicle Type</div>
                        <div class="value">{{ ucfirst(str_replace('_', ' ', $vehicle->vehicle_type)) }}</div>
                    </div>
                    <div class="kv">
                        <div class="label">Number Plate</div>
                        <div class="value">{{ $vehicle->number_plate }}</div>
                    </div>
                    <div class="kv">
                        <div class="label">Model</div>
                        <div class="value">{{ $vehicle->model ?? 'N/A' }}</div>
                    </div>
                    <div class="kv">
                        <div class="label">Year</div>
                        <div class="value">{{ $vehicle->year ?? 'N/A' }}</div>
                    </div>
                    <div class="kv">
                        <div class="label">Seat Count</div>
                        <div class="value">{{ $vehicle->seat_count }}</div>
                    </div>
                    <div class="kv">
                        <div class="label">Status</div>
                        <div class="value">{{ ucfirst($vehicle->status) }}</div>
                    </div>

                    <div class="desc">
                        <div class="label" style="margin-bottom:6px;">Description</div>
                        {{ $vehicle->description ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: media -->
        <div class="panel">
            <div class="panel-header"><strong>Photo</strong></div>
            <div class="panel-body">
                <div class="media-card">
                    <h6>Vehicle Image</h6>
                    @if ($vehicle->photo)
                        <img src="{{ asset('storage/' . $vehicle->photo) }}" alt="Vehicle Photo"
                             onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                    @else
                        <img src="{{ asset('images/placeholder.jpg') }}" alt="No Image">
                    @endif
                </div>
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
