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
    .breadcrumbs{ font-size:12px; color:var(--muted); }
    .breadcrumbs a{ color:inherit; text-decoration:none; }
    .title{ margin:0; font-size:26px; font-weight:800; letter-spacing:.2px; }

    /* Actions */
    .actions{ display:flex; gap:10px; flex-wrap:wrap; }

    /* Buttons */
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

    /* Panel */
    .panel{ background:var(--panel); border:1px solid var(--border); border-radius:var(--radius); box-shadow:var(--shadow-1); overflow:hidden; }
    .panel-body{ padding:24px; }

    /* Package Header */
    .package-header{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        margin-bottom:30px;
        padding-bottom:20px;
        border-bottom:1px solid var(--border);
    }
    .package-info h2{
        margin:0 0 10px 0;
        font-size:1.8rem;
        font-weight:800;
    }
    .package-meta{
        display:flex;
        flex-wrap:wrap;
        gap:15px;
        color:var(--muted);
        font-size:0.9rem;
    }
    .meta-item{
        display:flex;
        align-items:center;
        gap:6px;
    }
    .package-status{
        margin-top:10px;
    }

    /* Sections */
    .section{
        margin-bottom:30px;
    }
    .section h3{
        margin:0 0 15px 0;
        font-size:1.3rem;
        font-weight:800;
        color:var(--text);
    }

    /* Details Grid */
    .details-grid{
        display:grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap:15px;
    }
    .detail-item strong{
        display:block;
        margin-bottom:5px;
        font-weight:700;
    }

    /* Tags */
    .tags{
        display:flex;
        flex-wrap:wrap;
        gap:10px;
    }
    .tag{
        background:color-mix(in oklab, var(--panel), transparent 8%);
        border:1px solid var(--border);
        border-radius:999px;
        padding:6px 14px;
        font-size:13px;
        font-weight:700;
        color:var(--text);
    }

    /* Image Preview */
    .image-preview img{
        max-width:100%;
        height:auto;
        border-radius:10px;
        border:1px solid var(--border);
        box-shadow: var(--shadow-1);
    }

    /* Panel Footer */
    .panel-footer{
        display:flex;
        gap:15px;
        padding-top:20px;
        border-top:1px solid var(--border);
    }
    @media (max-width: 768px){
        .package-header{
            flex-direction:column;
            gap:15px;
        }
        .package-meta{
            flex-direction:column;
            gap:10px;
        }
        .panel-footer{
            flex-direction:column;
        }
        .panel-footer .btn{
            width:100%;
            justify-content:center;
        }
    }

    /* Chips for Status */
    .chip{ display:inline-flex; align-items:center; gap:8px; height:28px; padding:0 12px; border-radius:999px;
           border:1px solid var(--ring); font-size:12px; font-weight:800; color:var(--text);
           background: color-mix(in oklab, var(--panel), transparent 8%); }
    .chip-dot{ width:8px; height:8px; border-radius:999px; }
    .chip-active{ color: var(--accent-2); border-color: color-mix(in oklab, var(--accent-2), #000 15%); }
    .chip-inactive{ color: var(--warning); border-color: var(--warning); }
    .chip-active .chip-dot{ background: var(--accent-2); }
    .chip-inactive .chip-dot{ background: var(--warning); }
</style>

<div class="shell" id="custom-package-view-root">
    <div class="page-header">
        <div>
            <div class="breadcrumbs">
                <a href="{{ route('admin.custom-packages.index') }}">Custom Packages</a> / <span>View</span>
            </div>
            <h1 class="title">{{ $customPackage->title }}</h1>
        </div>
        <div class="actions">
            <button class="btn" id="themeToggle" type="button">Theme</button>
            <a href="{{ route('admin.custom-packages.index') }}" class="btn">Back</a>
        </div>
    </div>

    <div class="panel">
        <div class="panel-body">
            <div class="package-header">
                <div class="package-info">
                    <h2>{{ $customPackage->title }}</h2>
                    <div class="package-meta">
                        <span class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                            </svg>
                            {{ $customPackage->duration }} Days
                        </span>
                        <span class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                            {{ $customPackage->price ? 'LKR ' . number_format($customPackage->price, 2) : 'Price not set' }}
                        </span>
                        <span class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            {{ $customPackage->num_people }} People
                        </span>
                    </div>
                </div>
                <div class="package-status">
                    @if(strtolower($customPackage->status) === 'active')
                        <span class="chip chip-active"><span class="chip-dot"></span>Active</span>
                    @else
                        <span class="chip chip-inactive"><span class="chip-dot"></span>Inactive</span>
                    @endif
                </div>
            </div>

            {{-- User --}}
            <div class="section">
                <h3>User</h3>
                <p>{{ $customPackage->user->name ?? 'N/A' }} ({{ $customPackage->user->email ?? 'N/A' }})</p>
            </div>

            {{-- Guider --}}
            @if($customPackage->guider_id)
            <div class="section">
                <h3>Assigned Guider</h3>
                <p>{{ $customPackage->guider?->first_name ?? '' }} {{ $customPackage->guider?->last_name ?? '' }} ({{ $customPackage->guider?->email ?? 'N/A' }})</p>
            </div>
            @endif

            {{-- Description --}}
            @if($customPackage->description)
            <div class="section">
                <h3>Description</h3>
                <p>{{ $customPackage->description }}</p>
            </div>
            @endif

            {{-- Travel Details --}}
            <div class="section">
                <h3>Travel Details</h3>
                <div class="details-grid">
                    <div class="detail-item">
                        <strong>Start Location:</strong>
                        <span>{{ $customPackage->start_location }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Travel Date:</strong>
                        <span>{{ $customPackage->travel_date ? $customPackage->travel_date->format('F j, Y') : 'Not specified' }}</span>
                    </div>
                </div>
            </div>

            {{-- Image --}}
            @if($customPackage->image)
            <div class="section">
                <h3>Package Image</h3>
                <div class="image-preview">
                    <img src="{{ asset('storage/' . $customPackage->image) }}" alt="Package Image" onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                </div>
            </div>
            @endif

            {{-- Destinations --}}
            @if($customPackage->destinations && is_array($customPackage->destinations) && count(array_filter($customPackage->destinations)) > 0)
            <div class="section">
                <h3>Destinations</h3>
                <div class="tags">
                    @foreach(array_filter($customPackage->destinations) as $destination)
                        <span class="tag">{{ $destination }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Vehicles --}}
            @if($customPackage->vehicles && is_array($customPackage->vehicles) && count(array_filter($customPackage->vehicles)) > 0)
            <div class="section">
                <h3>Vehicles</h3>
                <div class="tags">
                    @foreach(array_filter($customPackage->vehicles) as $vehicle)
                        <span class="tag">{{ $vehicle }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Accommodations --}}
            @if($customPackage->accommodations && is_array($customPackage->accommodations) && count(array_filter($customPackage->accommodations)) > 0)
            <div class="section">
                <h3>Accommodations</h3>
                <div class="tags">
                    @foreach(array_filter($customPackage->accommodations) as $accommodation)
                        <span class="tag">{{ $accommodation }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="panel-footer">
                <a href="{{ route('admin.custom-packages.edit', $customPackage) }}" class="btn btn-primary">Edit Package</a>
                <form action="{{ route('admin.custom-packages.destroy', $customPackage) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this package?')">Delete Package</button>
                </form>
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