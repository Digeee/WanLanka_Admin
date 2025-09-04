@extends('admin.layouts.master')

@section('content')
<style>
    /* ====== Design Tokens (Light / Dark) ====== */
    :root{
        --bg: #f8fafc;              /* light surface */
        --panel: #ffffff;           /* cards */
        --muted: #64748b;           /* slate-500 */
        --text: #0f172a;            /* slate-900 */
        --border: #e2e8f0;          /* slate-200 */
        --ring: #cbd5e1;            /* slate-300 */
        --accent: #3b82f6;          /* blue-500 */
        --accent-2: #22c55e;        /* green-500 */
        --danger: #ef4444;          /* red-500 */
        --warning: #f59e0b;         /* amber-500 */
        --radius: 16px;
        --shadow-1: 0 10px 20px rgba(2,6,23, .06);
        --shadow-2: 0 18px 40px rgba(2,6,23, .08);
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
    .shell{
        max-width: 1200px;
        margin: 28px auto 80px;
        padding: 0 20px;
        color: var(--text);
    }
    .page-header{
        display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:18px;
    }
    .breadcrumbs{
        font-size: 12px; color: var(--muted); letter-spacing:.25px;
    }
    .breadcrumbs a{ color: inherit; text-decoration:none; }
    .title-row{
        display:flex; align-items:center; gap:14px; flex-wrap:wrap;
    }
    .page-title{ margin:0; font-size: 28px; font-weight: 800; letter-spacing:.2px; color: var(--text); }
    .sub{ color: var(--muted); font-weight: 600; }

    /* ====== Chips / Badges ====== */
    .chip{
        display:inline-flex; align-items:center; gap:8px;
        height: 28px; padding: 0 12px; border-radius: 999px;
        border: 1px solid var(--border); font-size:12px; font-weight:700;
        background: color-mix(in oklab, var(--panel), transparent 10%);
    }
    .chip-dot{ width:8px; height:8px; border-radius:999px; }
    .chip-available .chip-dot{ background: var(--accent-2); }
    .chip-unavailable .chip-dot{ background: var(--danger); }
    .chip-status-active{ border-color: color-mix(in oklab, var(--accent), #000 15%); color: var(--accent); }
    .chip-status-inactive{ border-color: var(--warning); color: var(--warning); }

    /* ====== Cards / Panels ====== */
    .panel{
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow-1);
        overflow: clip;
    }
    .panel:hover{ box-shadow: var(--shadow-2); transition: box-shadow .25s ease; }
    .panel-header{
        display:flex; align-items:center; justify-content:space-between; gap:12px;
        padding: 16px 18px; border-bottom: 1px solid var(--border);
        background:
            linear-gradient(180deg, color-mix(in oklab, var(--panel), transparent 92%), transparent),
            radial-gradient(1000px 100px at 0 -20%, color-mix(in oklab, var(--accent), transparent 92%), transparent);
    }
    .panel-body{ padding: 18px; }

    /* ====== Layout ====== */
    .layout{
        display:grid; gap:16px;
        grid-template-columns: 1fr; 
    }
    @media (min-width: 900px){
        .layout{ grid-template-columns: 1.3fr .8fr; }
    }

    /* ====== Key-Value Grid ====== */
    .kv-grid{
        display:grid; gap:12px;
        grid-template-columns: 1fr; 
    }
    @media (min-width: 700px){
        .kv-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); }
    }
    .kv{
        border:1px solid var(--border);
        border-radius: 12px; padding:12px 14px;
        background: color-mix(in oklab, var(--panel), transparent 6%);
    }
    .kv .label{
        font-size:12px; text-transform:uppercase; letter-spacing:.5px; color: var(--muted); margin-bottom:6px;
    }
    .kv .value{
        font-size:15px; font-weight:700; word-break:break-word;
    }
    .badges{ display:flex; flex-wrap:wrap; gap:8px; }
    .badge{
        font-size:12px; font-weight:700; border:1px solid var(--ring);
        padding:6px 10px; border-radius:999px; background: color-mix(in oklab, var(--panel), transparent 8%);
    }

    /* ====== Description ====== */
    .desc{
        border:1px dashed var(--ring); border-radius:12px; padding:14px; line-height:1.6;
        background: color-mix(in oklab, var(--panel), transparent 4%);
        grid-column: 1 / -1;
    }

    /* ====== Media ====== */
    .media-grid{ display:grid; gap:14px; }
    .media-card{ border:1px solid var(--border); border-radius:12px; padding:12px; background: color-mix(in oklab, var(--panel), transparent 6%); }
    .media-card h6{ margin:0 0 8px; font-size:12px; color: var(--muted); text-transform:uppercase; letter-spacing:.5px; }
    .media-card img{ width:100%; aspect-ratio: 16/10; object-fit:cover; border-radius:10px; display:block; }

    /* ====== Stats Aside ====== */
    .stats{
        display:grid; gap:10px;
        grid-template-columns: repeat(3, minmax(0,1fr));
    }
    .stat{
        border:1px solid var(--border); border-radius:12px; padding:12px; text-align:center;
        background: color-mix(in oklab, var(--panel), transparent 6%);
    }
    .stat small{ color: var(--muted); display:block; margin-bottom:6px; text-transform:uppercase; font-weight:700; letter-spacing:.4px; }
    .stat strong{ font-size:18px; }

    /* ====== Avatar (with fallback initials) ====== */
    .avatar{
        width:48px; height:48px; border-radius:12px; overflow:hidden; border:1px solid var(--border);
        background: linear-gradient(135deg, color-mix(in oklab, var(--accent), transparent 70%), color-mix(in oklab, var(--panel), transparent 30%));
        display:grid; place-items:center; color:#fff; font-weight:800;
    }
    .avatar > img{ width:100%; height:100%; object-fit:cover; display:block; }

    /* ====== Actions ====== */
    .actions{ display:flex; flex-wrap:wrap; gap:10px; }
    .btn{
        appearance:none; border:none; cursor:pointer; font-weight:800; letter-spacing:.3px;
        border-radius:12px; padding:12px 16px; color:#fff; box-shadow: var(--shadow-1);
        transition: transform .06s ease, box-shadow .2s ease, opacity .2s ease;
    }
    .btn:active{ transform: translateY(1px); }
    .btn-primary{ background: linear-gradient(180deg, color-mix(in oklab, var(--accent), #000 8%), var(--accent)); }
    .btn-danger{ background: linear-gradient(180deg, color-mix(in oklab, var(--danger), #000 8%), var(--danger)); }
    .btn-neutral{ background: linear-gradient(180deg, color-mix(in oklab, var(--muted), #000 12%), var(--muted)); }
    .btn:hover{ box-shadow: var(--shadow-2); opacity:.98; }

    /* ====== Sticky mobile action bar ====== */
    .action-bar{
        position: sticky; bottom: -1px; z-index: 10;
        margin-top: 16px;
        backdrop-filter: var(--glass);
        background: color-mix(in oklab, var(--bg), transparent 35%);
        border-top: 1px solid var(--border);
        padding: 10px; border-radius: 12px;
    }
    @media (min-width: 900px){ .action-bar{ display:none; } }

    /* ====== Page BG ====== */
    body{
        background:
           radial-gradient(1200px 600px at 10% -10%, color-mix(in oklab, var(--accent), transparent 94%), transparent),
           var(--bg);
    }

    /* ====== Focus / Accessibility ====== */
    .btn, a, button { outline: none; }
    .btn:focus-visible, a:focus-visible, button:focus-visible{
        box-shadow: 0 0 0 3px color-mix(in oklab, var(--accent), transparent 65%);
    }

    /* ==== DARK THEME READABILITY PATCH (name & header) ==== */
    .page-header{ position: relative; z-index: 2; }
    [data-theme="dark"] .title-row .page-title{
        color: #f8fafc !important;
        text-shadow: 0 1px 0 rgba(0,0,0,.45);
    }
    [data-theme="dark"] .page-header .sub{
        color: #cbd5e1 !important;
    }
    [data-theme="dark"] .page-header{
        background: linear-gradient(180deg, #0f172a, #0b1220);
        border: 1px solid var(--ring);
        border-radius: 16px;
        padding: 12px 16px;
        backdrop-filter: blur(6px) saturate(1.05);
    }
    [data-theme="dark"] #guider-details-root{
        background: linear-gradient(180deg, rgba(2,6,23,.65), rgba(2,6,23,.35));
        border-radius: 18px;
        padding-top: 6px;
    }
</style>

<div class="shell" id="guider-details-root">
    <!-- Breadcrumbs + Theme toggle -->
    <div class="page-header">
        <div>
            <div class="breadcrumbs">
                <a href="{{ route('admin.guiders.index') }}">Guiders</a> / <span>Details</span>
            </div>
            <div class="title-row" style="margin-top:6px;">
                <div class="avatar">
                    @if ($guider->image)
                        <img src="{{ asset('storage/' . $guider->image) }}" alt="Avatar"
                             onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                    @else
                        <span>{{ strtoupper(substr($guider->first_name,0,1).substr($guider->last_name,0,1)) }}</span>
                    @endif
                </div>
                <div>
                    <h1 class="page-title">{{ $guider->first_name }} {{ $guider->last_name }}</h1>
                    <div class="sub">{{ $guider->city ?? '—' }}</div>
                </div>
            </div>
        </div>
        <div class="actions">
            <button class="btn btn-neutral" type="button" id="themeToggle" aria-label="Toggle theme">Theme</button>
            <a href="{{ route('admin.guiders.edit', $guider) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('admin.guiders.destroy', $guider) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this guider?')">Delete</button>
            </form>
        </div>
    </div>

    <!-- Chips row -->
    <div class="panel" style="margin-bottom:14px;">
        <div class="panel-header">
            <div class="actions" style="flex-wrap:wrap;">
                @if($guider->availability)
                    <span class="chip chip-available"><span class="chip-dot"></span>Available</span>
                @else
                    <span class="chip chip-unavailable"><span class="chip-dot"></span>Not Available</span>
                @endif

                @php $status = strtolower((string) $guider->status); @endphp
                @if(in_array($status, ['active','approved','enabled']))
                    <span class="chip chip-status-active">{{ ucfirst($guider->status) }}</span>
                @else
                    <span class="chip chip-status-inactive">{{ ucfirst($guider->status) }}</span>
                @endif
            </div>
            <div class="actions">
                <span class="chip" title="Hourly Rate">${{ number_format($guider->hourly_rate, 2) }}/hr</span>
                <span class="chip" title="Experience">{{ $guider->experience_years }} yrs</span>
            </div>
        </div>
    </div>

    <div class="layout">
        <!-- Main column -->
        <div class="panel">
            <div class="panel-header"><strong>Profile</strong></div>
            <div class="panel-body">
                <div class="kv-grid">
                    <div class="kv">
                        <div class="label">Email</div>
                        <div class="value">{{ $guider->email }}</div>
                    </div>
                    <div class="kv">
                        <div class="label">Phone</div>
                        <div class="value">{{ $guider->phone ?? 'N/A' }}</div>
                    </div>
                    <div class="kv">
                        <div class="label">Address</div>
                        <div class="value">{{ $guider->address ?? 'N/A' }}</div>
                    </div>
                    <div class="kv">
                        <div class="label">City</div>
                        <div class="value">{{ $guider->city ?? 'N/A' }}</div>
                    </div>

                    <div class="kv">
                        <div class="label">Languages</div>
                        <div class="value">
                            @if($guider->languages && count($guider->languages))
                                <div class="badges">
                                    @foreach($guider->languages as $lang)
                                        <span class="badge">{{ $lang }}</span>
                                    @endforeach
                                </div>
                            @else
                                N/A
                            @endif
                        </div>
                    </div>

                    <div class="kv">
                        <div class="label">Specializations</div>
                        <div class="value">
                            @if($guider->specializations && count($guider->specializations))
                                <div class="badges">
                                    @foreach($guider->specializations as $sp)
                                        <span class="badge">{{ $sp }}</span>
                                    @endforeach
                                </div>
                            @else
                                N/A
                            @endif
                        </div>
                    </div>

                    <div class="kv">
                        <div class="label">NIC Number</div>
                        <div class="value">{{ $guider->nic_number ?? 'N/A' }}</div>
                    </div>
                    <div class="kv">
                        <div class="label">Vehicle Types</div>
                        <div class="value">
                            @if($guider->vehicle_types && count($guider->vehicle_types))
                                <div class="badges">
                                    @foreach($guider->vehicle_types as $vt)
                                        <span class="badge">{{ $vt }}</span>
                                    @endforeach
                                </div>
                            @else
                                N/A
                            @endif
                        </div>
                    </div>

                    <div class="desc">
                        <div class="label" style="margin-bottom:6px;">Description</div>
                        {{ $guider->description ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Aside -->
        <div class="panel">
            <div class="panel-header"><strong>Media & Quick Stats</strong></div>
            <div class="panel-body">
                <div class="stats" style="margin-bottom:12px;">
                    <div class="stat"><small>Rate</small><strong>${{ number_format($guider->hourly_rate, 2) }}</strong></div>
                    <div class="stat"><small>Experience</small><strong>{{ $guider->experience_years }}y</strong></div>
                    <div class="stat"><small>Availability</small><strong>{{ $guider->availability ? 'Yes' : 'No' }}</strong></div>
                </div>

                <div class="media-grid">
                    <div class="media-card">
                        <h6>Profile Image</h6>
                        @if ($guider->image)
                            <img src="{{ asset('storage/' . $guider->image) }}" alt="Guider Image"
                                 onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                        @else
                            <img src="{{ asset('images/placeholder.jpg') }}" alt="No Image">
                        @endif
                    </div>
                    <div class="media-card">
                        <h6>Driving License</h6>
                        @if ($guider->driving_license_photo)
                            <img src="{{ asset('storage/' . $guider->driving_license_photo) }}" alt="Driving License Photo"
                                 onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                        @else
                            <img src="{{ asset('images/placeholder.jpg') }}" alt="No License Photo">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary action bar (mobile) -->
    <div class="action-bar">
        <div class="actions" style="justify-content:space-between;">
            <a href="{{ route('admin.guiders.index') }}" class="btn btn-neutral" style="color:#fff;">Back</a>
            <div class="actions">
                <a href="{{ route('admin.guiders.edit', $guider) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('admin.guiders.destroy', $guider) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete this guider?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Theme toggle (remembers preference)
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
        // Respect system preference on first load
        if(!saved && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches){
            root.setAttribute('data-theme','dark');
        }
    })();
</script>
@endsection
