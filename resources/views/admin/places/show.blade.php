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

    /* ====== Page Shell ====== */
    .shell{max-width:1100px;margin:28px auto 80px;padding:0 20px;color:var(--text);}
    body{
        background:
           radial-gradient(1200px 600px at 10% -10%, color-mix(in oklab, var(--accent), transparent 94%), transparent),
           var(--bg);
    }

    /* Header */
    .page-header{
        display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:18px;
        background:linear-gradient(180deg,color-mix(in oklab,var(--panel),transparent 4%),transparent);
        border:1px solid var(--border);border-radius:16px;padding:12px 16px;box-shadow:var(--shadow-1);
    }
    [data-theme="dark"] .page-header{
        background: linear-gradient(180deg, #0f172a, #0b1220);
        border:1px solid var(--ring);
    }
    .breadcrumbs{font-size:12px;color:var(--muted);}
    .breadcrumbs a{color:inherit;text-decoration:none;}
    .title-row{display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-top:6px;}
    .page-title{margin:0;font-size:28px;font-weight:800;letter-spacing:.2px;}
    [data-theme="dark"] .page-title{color:#f8fafc;text-shadow:0 1px 0 rgba(0,0,0,.45);}
    .sub{color:var(--muted);font-weight:600;}
    .actions{display:flex;gap:10px;flex-wrap:wrap;}

    /* ====== Buttons (glossy pill, your style) ====== */
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

    /* ====== Panels ====== */
    .panel{background:var(--panel);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-1);overflow:clip;}
    .panel-header{
        display:flex;align-items:center;justify-content:space-between;gap:12px;
        padding:16px 18px;border-bottom:1px solid var(--border);
        background:
            linear-gradient(180deg, color-mix(in oklab, var(--panel), transparent 92%), transparent),
            radial-gradient(1000px 100px at 0 -20%, color-mix(in oklab, var(--accent), transparent 92%), transparent);
        font-weight:800;
    }
    .panel-body{padding:18px;}

    /* ====== Layout ====== */
    .layout{display:grid;gap:16px;grid-template-columns:1fr;}
    @media (min-width: 900px){ .layout{ grid-template-columns: 1.3fr .8fr; } }

    /* ====== Key-Value Grid ====== */
    .kv-grid{display:grid;gap:12px;grid-template-columns:1fr;}
    @media (min-width: 700px){ .kv-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); } }
    .kv{border:1px solid var(--border);border-radius:12px;padding:12px 14px;background:color-mix(in oklab,var(--panel),transparent 6%);}
    .kv .label{font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--muted);margin-bottom:6px;}
    .kv .value{font-size:15px;font-weight:700;word-break:break-word;}
    .desc{border:1px dashed var(--ring);border-radius:12px;padding:14px;line-height:1.6;background:color-mix(in oklab,var(--panel),transparent 4%);grid-column:1/-1;}

    /* ====== Avatar ====== */
    .avatar{
        width:48px;height:48px;border-radius:12px;overflow:hidden;border:1px solid var(--border);
        background:linear-gradient(135deg,color-mix(in oklab,var(--accent),transparent 70%),color-mix(in oklab,var(--panel),transparent 30%));
        display:grid;place-items:center;color:#fff;font-weight:800;
    }
    :root .avatar{
      background:linear-gradient(135deg,color-mix(in oklab,var(--accent),white 70%),#eef2ff);
      border-color:#dbeafe;
    }
    :root .avatar > span{color:#0f172a !important;text-shadow:0 1px 0 rgba(255,255,255,.55);}
    [data-theme="dark"] .avatar{background:linear-gradient(135deg,color-mix(in oklab,var(--accent),transparent 70%),color-mix(in oklab,var(--panel),transparent 30%));}
    [data-theme="dark"] .avatar > span{color:#fff !important;}

    /* ====== Chips ====== */
    .chip{display:inline-flex;align-items:center;gap:8px;height:28px;padding:0 12px;border-radius:999px;border:1px solid var(--ring);font-size:12px;font-weight:800;color:var(--text);background:color-mix(in oklab,var(--panel),transparent 8%);}
    .chip-dot{width:8px;height:8px;border-radius:999px;}
    .chip-active{color:var(--accent);border-color:color-mix(in oklab,var(--accent),#000 15%);}
    .chip-inactive{color:var(--warning);border-color:var(--warning);}
    .chip-active .chip-dot{background:var(--accent-2);}
    .chip-inactive .chip-dot{background:var(--warning);}

    /* ====== Stats & Media ====== */
    .stats{display:grid;gap:10px;grid-template-columns:repeat(3,minmax(0,1fr));}
    .stat{border:1px solid var(--border);border-radius:12px;padding:12px;text-align:center;background:color-mix(in oklab,var(--panel),transparent 6%);}
    .stat small{color:var(--muted);display:block;margin-bottom:6px;text-transform:uppercase;font-weight:700;letter-spacing:.4px;}
    .stat strong{font-size:18px;}
    .media-grid{display:grid;gap:14px;}
    .media-card{border:1px solid var(--border);border-radius:12px;padding:12px;background:color-mix(in oklab,var(--panel),transparent 6%);}
    .media-card h6{margin:0 0 8px;font-size:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;}
    .media-card img{width:100%;aspect-ratio:16/10;object-fit:cover;border-radius:10px;display:block;}
    .gallery-preview{display:grid;grid-template-columns:repeat(auto-fill,minmax(110px,1fr));gap:10px;}
    .gallery-preview img{width:100%;height:78px;object-fit:cover;border-radius:10px;border:1px solid var(--border);}

    /* Mobile action bar (optional, hidden on desktop) */
    .action-bar{position:sticky;bottom:-1px;z-index:10;margin-top:16px;backdrop-filter:var(--glass);background:color-mix(in oklab,var(--bg),transparent 35%);border-top:1px solid var(--border);padding:10px;border-radius:12px;}
    @media (min-width:900px){.action-bar{display:none;}}
</style>

@php
    $n = trim($place->name ?? '');
    $bits = preg_split('/\s+/', $n);
    $initials = strtoupper((substr($bits[0] ?? '',0,1)) . (substr($bits[1] ?? '',0,1)));
    $status = strtolower((string) $place->status);
    $isActive = in_array($status, ['active','approved','enabled']);
@endphp

<div class="shell" id="place-details-root">
    <div class="page-header">
        <div>
            <div class="breadcrumbs">
                <a href="{{ route('admin.places.index') }}">Places</a> / <span>Details</span>
            </div>
            <div class="title-row">
                <div class="avatar"><span>{{ $initials ?: 'PL' }}</span></div>
                <div>
                    <h1 class="page-title">{{ $place->name }}</h1>
                    <div class="sub">
                        {{ $place->province ?? '—' }}{{ $place->district ? ' • '.$place->district : '' }}
                    </div>
                </div>
            </div>
        </div>
        <div class="actions">
            <button class="btn btn-neutral" type="button" id="themeToggle" aria-label="Toggle theme">Theme</button>
            <a href="{{ route('admin.places.edit', $place) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('admin.places.destroy', $place) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this place?')">Delete</button>
            </form>
        </div>
    </div>

    <!-- Status & quick chips -->
    <div class="panel" style="margin-bottom:14px;">
        <div class="panel-header">
            <div class="actions" style="flex-wrap:wrap;">
                @if($isActive)
                    <span class="chip chip-active"><span class="chip-dot"></span>Active</span>
                @else
                    <span class="chip chip-inactive"><span class="chip-dot"></span>{{ ucfirst($place->status) }}</span>
                @endif
                @if(!is_null($place->rating) && $place->rating !== '')
                    <span class="chip" title="Rating">★ {{ number_format($place->rating, 1) }}</span>
                @endif
            </div>
            <div class="actions">
                @if(!is_null($place->entry_fee))
                    <span class="chip" title="Entry Fee">${{ number_format($place->entry_fee, 2) }}</span>
                @endif
                @if(!empty($place->best_time_to_visit))
                    <span class="chip" title="Best Time">{{ $place->best_time_to_visit }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="layout">
        <!-- Main details -->
        <div class="panel">
            <div class="panel-header"><strong>Details</strong></div>
            <div class="panel-body">
                <div class="kv-grid">
                    <div class="kv">
                        <div class="label">Province</div>
                        <div class="value">{{ $place->province ?? 'N/A' }}</div>
                    </div>
                    <div class="kv">
                        <div class="label">District</div>
                        <div class="value">{{ $place->district ?? 'N/A' }}</div>
                    </div>

                    <div class="kv">
                        <div class="label">Location</div>
                        <div class="value">{{ $place->location ?? 'N/A' }}</div>
                    </div>
                    <div class="kv">
                        <div class="label">Weather</div>
                        <div class="value">{{ $place->weather ?? 'N/A' }}</div>
                    </div>

                    <div class="kv">
                        <div class="label">Travel Type</div>
                        <div class="value">{{ $place->travel_type ?? 'N/A' }}</div>
                    </div>
                    <div class="kv">
                        <div class="label">Season</div>
                        <div class="value">{{ $place->season ?? 'N/A' }}</div>
                    </div>

                    <div class="kv">
                        <div class="label">Latitude</div>
                        <div class="value">{{ $place->latitude ?? 'N/A' }}</div>
                    </div>
                    <div class="kv">
                        <div class="label">Longitude</div>
                        <div class="value">{{ $place->longitude ?? 'N/A' }}</div>
                    </div>

                    <div class="desc">
                        <div class="label" style="margin-bottom:6px;">Description</div>
                        {{ $place->description ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Media & stats -->
        <div class="panel">
            <div class="panel-header"><strong>Media & Quick Stats</strong></div>
            <div class="panel-body">
                <div class="stats" style="margin-bottom:12px;">
                    <div class="stat"><small>Entry Fee</small><strong>
                        @if(!is_null($place->entry_fee)) ${{ number_format($place->entry_fee,2) }} @else — @endif
                    </strong></div>
                    <div class="stat"><small>Rating</small><strong>
                        @if(!is_null($place->rating) && $place->rating !== '') {{ number_format($place->rating,1) }} @else — @endif
                    </strong></div>
                    <div class="stat"><small>Status</small><strong>{{ ucfirst($place->status) }}</strong></div>
                </div>

                <div class="media-grid">
                    <div class="media-card">
                        <h6>Cover Image</h6>
                        @if ($place->image)
                            <img src="{{ asset('storage/' . $place->image) }}" alt="Place Image"
                                 onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                        @else
                            <img src="{{ asset('images/placeholder.jpg') }}" alt="No Image">
                        @endif
                    </div>

                    <div class="media-card">
                        <h6>Gallery</h6>
                        @if ($place->gallery)
                            <div class="gallery-preview">
                                @foreach ($place->gallery as $galleryImage)
                                    <img src="{{ asset('storage/' . $galleryImage) }}" alt="Gallery Image"
                                         onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                                @endforeach
                            </div>
                        @else
                            <div class="sub">N/A</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile action bar -->
    <div class="action-bar">
        <div class="actions" style="justify-content:space-between;">
            <a href="{{ route('admin.places.index') }}" class="btn btn-neutral">Back</a>
            <div class="actions">
                <a href="{{ route('admin.places.edit', $place) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('admin.places.destroy', $place) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete this place?')">Delete</button>
                </form>
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
