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

    .btn-danger{
        --fg: color-mix(in oklab, var(--danger), #000 25%);
        --bd: color-mix(in oklab, var(--danger), #000 18%);
        --fill: color-mix(in oklab, var(--panel), transparent 0%);
    }
    .btn-danger:hover{
        color:#fff; text-shadow: 0 1px 0 rgba(0,0,0,.25);
        background-image: var(--shine), linear-gradient(180deg, color-mix(in oklab, var(--danger), #000 8%), var(--danger)), linear-gradient(135deg, color-mix(in oklab, var(--danger), #000 18%), color-mix(in oklab, var(--danger), #000 28%));
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
    .panel-header{ padding:14px 16px; border-bottom:1px solid var(--border); font-weight:800; }
    .panel-body{ padding:16px; }

    /* Alerts */
    .alert{ border-radius:12px; padding:12px 14px; font-weight:700; }
    .alert-success{ color:#065f46; background:#ecfdf5; border:1px solid #a7f3d0; }
    [data-theme="dark"] .alert-success{ color:#bbf7d0; background:rgba(6,95,70,.15); border:1px solid #134e4a; }

    /* Table */
    .table-wrap{ overflow:auto; border:1px solid var(--border); border-radius:14px; }
    table.data{ width:100%; border-collapse:separate; border-spacing:0; min-width:1200px; background:color-mix(in oklab, var(--panel), transparent 2%); }
    .data thead th{
        position:sticky; top:0; z-index:1; text-align:left; font-size:12px; text-transform:uppercase; letter-spacing:.5px;
        color:var(--muted); background: color-mix(in oklab, var(--panel), transparent 2%);
        border-bottom:1px solid var(--border); padding:12px 14px;
    }
    .data tbody td{ padding:14px; border-bottom:1px solid var(--border); vertical-align:middle; }
    .data tbody tr:hover{ background: color-mix(in oklab, var(--panel), transparent 6%); }

    /* Image in table */
    .place-image{
        width:50px; height:50px; border-radius:8px; object-fit:cover; border:1px solid var(--border);
        display:block;
    }

    /* Chips for status */
    .chip{ display:inline-flex; align-items:center; gap:8px; height:28px; padding:0 12px; border-radius:999px;
           border:1px solid var(--ring); font-size:12px; font-weight:800; color:var(--text);
           background: color-mix(in oklab, var(--panel), transparent 8%); }
    .chip-dot{ width:8px; height:8px; border-radius:999px; }
    .chip-approved{ color: var(--accent-2); border-color: color-mix(in oklab, var(--accent-2), #000 15%); }
    .chip-pending{ color: var(--warning); border-color: var(--warning); }
    .chip-rejected{ color: var(--danger); border-color: color-mix(in oklab, var(--danger), #000 15%); }
    .chip-approved .chip-dot{ background: var(--accent-2); }
    .chip-pending .chip-dot{ background: var(--warning); }
    .chip-rejected .chip-dot{ background: var(--danger); }

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

    [data-theme="dark"] .page-header{ background: linear-gradient(180deg, #0f172a, #0b1220); border:1px solid var(--ring); }
</style>

<div class="shell" id="user-sent-places-root">
    <div class="page-header">
        <div>
            <div class="breadcrumbs">
                <a href="{{ route('admin.places.user-sent.index') }}">Places</a> / <span>User Sent</span>
            </div>
            <h1 class="title">User Sent Places</h1>
        </div>
        <div class="actions">
            <button class="btn btn-primary" id="themeToggle" type="button">Theme</button>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="panel">
        <div class="panel-header">Submitted Places</div>
        <div class="panel-body">
            <div class="table-wrap">
                <table class="data">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Place Name</th>
                            <th>Image</th>
                            <th>Map</th>
                            <th>Province</th>
                            <th>District</th>
                            <th>Location</th>
                            <th>City</th>
                            <th>Description</th>
                            <th>Suited For</th>
                            <th>Activities</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th style="min-width:220px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($places as $place)
                            @php
                                $status = strtolower($place->status ?? 'pending');
                                $chipClass = match($status) {
                                    'approved' => 'chip-approved',
                                    'rejected' => 'chip-rejected',
                                    default => 'chip-pending'
                                };
                            @endphp
                            <tr>
                                <td>{{ $place->id }}</td>
                                <td style="font-weight:800;">{{ $place->user_name ?? '—' }}</td>
                                <td style="font-size:13px; color:var(--muted);">{{ $place->user_email ?? '—' }}</td>
                                <td style="font-weight:800;">{{ $place->place_name ?? '—' }}</td>
                                <td>
                                    @if($place->image)
                                        <img src="{{ asset('storage/' . $place->image) }}" alt="Place" class="place-image">
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
                                    @if($place->google_map_link)
                                        <a href="{{ $place->google_map_link }}" target="_blank" class="btn btn-primary" style="padding:6px 10px; font-size:12px;">Map</a>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>{{ $place->province ?? '—' }}</td>
                                <td>{{ $place->district ?? '—' }}</td>
                                <td>{{ $place->location ?? '—' }}</td>
                                <td>{{ $place->nearest_city ?? '—' }}</td>
                                <td style="max-width:160px; word-wrap:break-word;">{{ Str::limit($place->description, 50) }}</td>
                                <td>{{ $place->best_suited_for ?? '—' }}</td>
                                <td style="max-width:140px; word-wrap:break-word;">{{ Str::limit($place->activities_offered, 30) }}</td>
                                <td>{{ $place->rating ? $place->rating . '/5' : '—' }}</td>
                                <td>
                                    <span class="chip {{ $chipClass }}">
                                        <span class="chip-dot"></span>
                                        {{ ucfirst($place->status ?? 'Pending') }}
                                    </span>
                                </td>
                                <td style="font-size:13px; color:var(--muted);">{{ $place->created_at->format('M j, Y') }}</td>
                                <td>
                                    <div class="actions" style="gap:8px;">
                                        <a href="{{ route('admin.places.user-sent.show', $place->id) }}" class="btn btn-primary">View</a>
                                        <a href="{{ route('admin.places.user-sent.edit', $place->id) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('admin.places.user-sent.destroy', $place->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this place?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="17" style="text-align:center; padding:24px; color:var(--muted);">
                                    No user-sent places found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
