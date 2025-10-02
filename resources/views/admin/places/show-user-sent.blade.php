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
        background-image: var(--shine), linear-gradient(var(--fill), var(--fill)), linear-gradient(135deg, var(--bd), color-mix(in oklab, var(--bd), #000 12%));
        background-origin: padding-box, padding-box, border-box;
        background-clip: padding-box, padding-box, border-box;
        background-size: 220% 100%, 100% 100%, 100% 100%;
        background-position: -120% 0, 0 0, 0 0;
        border:1.5px solid transparent;
        color: var(--fg);
        box-shadow: var(--shadow-1);
        transition: background-position .6s ease, box-shadow .25s ease, color .25s ease;
        overflow:hidden;
        backface-visibility:hidden;
    }
    .btn:hover{ background-position: 120% 0, 0 0, 0 0; box-shadow: var(--shadow-2); }
    .btn:active{ transform: translateY(1px); }
    .btn:focus-visible{ outline:none; box-shadow: 0 0 0 3px color-mix(in oklab, var(--accent), transparent 60%), var(--shadow-2); }

    .btn-primary{
        --fg: color-mix(in oklab, var(--accent), #000 35%);
        --bd: color-mix(in oklab, var(--accent), #000 15%);
        --fill: color-mix(in oklab, var(--panel), transparent 0%);
    }
    .btn-primary:hover{
        color:#fff; text-shadow: 0 1px 0 rgba(0,0,0,.25);
        background-image: var(--shine), linear-gradient(180deg, color-mix(in oklab, var(--accent), #000 10%), var(--accent)), linear-gradient(135deg, color-mix(in oklab, var(--accent), #000 15%), color-mix(in oklab, var(--accent), #000 26%));
        border-color: transparent;
    }
    [data-theme="dark"] .btn-primary{
        --fg: color-mix(in oklab, var(--accent), white 45%);
        --bd: color-mix(in oklab, var(--accent), white 18%);
        --fill: color-mix(in oklab, var(--panel), transparent 10%);
    }

    .btn-secondary{
        --fg: color-mix(in oklab, var(--muted), #000 10%);
        --bd: var(--ring);
        --fill: color-mix(in oklab, var(--panel), transparent 12%);
    }
    .btn-secondary:hover{
        --fill: color-mix(in oklab, var(--panel), transparent 0%);
        --fg: var(--text);
    }

    /* Panel */
    .panel{ background:var(--panel); border:1px solid var(--border); border-radius:var(--radius); box-shadow:var(--shadow-1); overflow:hidden; }
    .panel-header{ padding:14px 16px; border-bottom:1px solid var(--border); font-weight:800; }
    .panel-body{ padding:24px; }

    /* Place Image */
    .place-image{
        width:300px; height:200px; object-fit:cover; border-radius:12px;
        border:1px solid var(--border); display:block; margin-bottom:20px;
    }

    /* Detail Rows */
    .detail-row{
        margin-bottom:12px; display:flex; gap:12px;
    }
    .detail-label{
        font-weight:700; color:var(--muted); min-width:180px;
    }
    .detail-value{
        flex:1; color:var(--text);
    }
    .detail-value a{
        color:var(--accent); text-decoration:underline;
    }
    .detail-value a:hover{
        color:color-mix(in oklab, var(--accent), #000 20%);
    }
    [data-theme="dark"] .detail-value a:hover{
        color:color-mix(in oklab, var(--accent), white 20%);
    }

    /* Status Badge */
    .status-badge{
        display:inline-block; padding:4px 10px; border-radius:999px; font-size:13px; font-weight:800;
        background: color-mix(in oklab, var(--panel), transparent 8%);
        border:1px solid var(--ring); color:var(--text);
    }
    .status-approved{ background: rgba(34,197,94,.15); color: var(--accent-2); border-color: color-mix(in oklab, var(--accent-2), #000 20%); }
    .status-pending{ background: rgba(245,158,11,.15); color: var(--warning); border-color: color-mix(in oklab, var(--warning), #000 20%); }
    .status-rejected{ background: rgba(239,68,68,.15); color: var(--danger); border-color: color-mix(in oklab, var(--danger), #000 20%); }

    /* Action Buttons */
    .form-actions{ display:flex; gap:12px; margin-top:24px; flex-wrap:wrap; }
</style>

<div class="shell" id="user-sent-place-show">
    <div class="page-header">
        <div>
            <div class="breadcrumbs">
                <a href="{{ route('admin.places.user-sent.index') }}">Places</a> / <span>View</span>
            </div>
            <h1 class="title">User-Sent Place #{{ $place->id }}</h1>
        </div>
        <div class="actions">
            <button class="btn btn-primary" id="themeToggle" type="button">Theme</button>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">Place Details</div>
        <div class="panel-body">

            <!-- User Info -->
            <div class="detail-row">
                <div class="detail-label">Submitted By</div>
                <div class="detail-value">{{ $place->user_name ?? '—' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Email</div>
                <div class="detail-value">{{ $place->user_email ?? '—' }}</div>
            </div>
            <hr style="border:0; border-top:1px solid var(--border); margin:20px 0;">

            <!-- Image -->
            @if($place->image)
                <img src="{{ asset('storage/' . $place->image) }}" alt="Place Image" class="place-image">
            @endif

            <!-- Place Details -->
            <div class="detail-row">
                <div class="detail-label">Place Name</div>
                <div class="detail-value">{{ $place->place_name ?? '—' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Google Map</div>
                <div class="detail-value">
                    @if($place->google_map_link)
                        <a href="{{ $place->google_map_link }}" target="_blank">Open Map</a>
                    @else
                        —
                    @endif
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Province</div>
                <div class="detail-value">{{ $place->province ?? '—' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">District</div>
                <div class="detail-value">{{ $place->district ?? '—' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Location</div>
                <div class="detail-value">{{ $place->location ?? '—' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Nearest City</div>
                <div class="detail-value">{{ $place->nearest_city ?? '—' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Description</div>
                <div class="detail-value">{{ $place->description ?? '—' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Best Suited For</div>
                <div class="detail-value">{{ $place->best_suited_for ?? '—' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Activities Offered</div>
                <div class="detail-value">{{ $place->activities_offered ?? '—' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Rating</div>
                <div class="detail-value">{{ $place->rating ? $place->rating . '/5' : '—' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    @php
                        $status = strtolower($place->status ?? 'pending');
                        $badgeClass = match($status) {
                            'approved' => 'status-approved',
                            'rejected' => 'status-rejected',
                            default => 'status-pending'
                        };
                    @endphp
                    <span class="status-badge {{ $badgeClass }}">
                        {{ ucfirst($place->status ?? 'Pending') }}
                    </span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Created At</div>
                <div class="detail-value">{{ $place->created_at ? $place->created_at->format('M j, Y \a\t g:i A') : '—' }}</div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.places.user-sent.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('admin.places.user-sent.edit', $place->id) }}" class="btn btn-primary">Edit</a>
            </div>

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
