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

    /* Alerts */
    .alert{ border-radius:12px; padding:12px 14px; font-weight:700; margin-bottom:20px; }
    .alert-success{ color:#065f46; background:#ecfdf5; border:1px solid #a7f3d0; }
    [data-theme="dark"] .alert-success{ color:#bbf7d0; background:rgba(6,95,70,.15); border:1px solid #134e4a; }

    /* Form Controls */
    .form-group{ margin-bottom:20px; }
    .form-label{
        display:block; font-size:14px; font-weight:700; margin-bottom:8px; color:var(--text);
    }
    .form-control{
        width:100%; padding:12px 14px; border:1.5px solid var(--border); border-radius:12px;
        background: color-mix(in oklab, var(--panel), transparent 2%);
        color: var(--text); font-size:15px;
        transition: border-color .2s ease, box-shadow .2s ease;
        box-shadow: none;
    }
    .form-control:focus{
        outline:none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px color-mix(in oklab, var(--accent), transparent 60%);
    }
    [data-theme="dark"] .form-control{
        background: color-mix(in oklab, var(--panel), transparent 6%);
        border-color: var(--ring);
    }

    .form-select{
        width:100%; padding:12px 14px; border:1.5px solid var(--border); border-radius:12px;
        background: color-mix(in oklab, var(--panel), transparent 2%);
        color: var(--text); font-size:15px;
        appearance: none;
        background-image: url("image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px 12px;
    }
    .form-select:focus{
        outline:none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px color-mix(in oklab, var(--accent), transparent 60%);
    }
    [data-theme="dark"] .form-select{
        background-color: color-mix(in oklab, var(--panel), transparent 6%);
        border-color: var(--ring);
        background-image: url("image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    }

    /* Image Preview */
    .image-preview{
        width:150px; height:150px; object-fit:cover; border-radius:12px;
        border:1px solid var(--border); display:block; margin-bottom:12px;
    }

    /* Action Buttons */
    .form-actions{ display:flex; gap:12px; margin-top:24px; flex-wrap:wrap; }
</style>

<div class="shell" id="user-sent-place-edit">
    <div class="page-header">
        <div>
            <div class="breadcrumbs">
                <a href="{{ route('admin.places.user-sent.index') }}">Places</a> / <span>Edit</span>
            </div>
            <h1 class="title">Edit User-Sent Place #{{ $place->id }}</h1>
        </div>
        <div class="actions">
            <button class="btn btn-primary" id="themeToggle" type="button">Theme</button>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="panel">
        <div class="panel-header">Edit Place Details</div>
        <div class="panel-body">
            <form action="{{ route('admin.places.user-sent.update', $place->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- User Info (Read-only) -->
                <div class="form-group">
                    <label for="user_name" class="form-label">User Name</label>
                    <input type="text" class="form-control" id="user_name" name="user_name"
                           value="{{ $place->user_name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="user_email" class="form-label">User Email</label>
                    <input type="text" class="form-control" id="user_email" name="user_email"
                           value="{{ $place->user_email }}" readonly>
                </div>

                <!-- Place Fields -->
                <div class="form-group">
                    <label for="place_name" class="form-label">Place Name</label>
                    <input type="text" class="form-control" id="place_name" name="place_name"
                           value="{{ old('place_name', $place->place_name) }}" required>
                </div>

                <div class="form-group">
                    <label for="image" class="form-label">Image</label>
                    @if($place->image)
                        <img src="{{ asset('storage/' . $place->image) }}" alt="Current Image" class="image-preview">
                    @endif
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="google_map_link" class="form-label">Google Map Link</label>
                    <input type="url" class="form-control" id="google_map_link" name="google_map_link"
                           value="{{ old('google_map_link', $place->google_map_link) }}" required>
                </div>

                <div class="form-group">
                    <label for="province" class="form-label">Province</label>
                    <input type="text" class="form-control" id="province" name="province"
                           value="{{ old('province', $place->province) }}" required>
                </div>

                <div class="form-group">
                    <label for="district" class="form-label">District</label>
                    <input type="text" class="form-control" id="district" name="district"
                           value="{{ old('district', $place->district) }}" required>
                </div>

                <div class="form-group">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location"
                           value="{{ old('location', $place->location) }}" required>
                </div>

                <div class="form-group">
                    <label for="nearest_city" class="form-label">Nearest City</label>
                    <input type="text" class="form-control" id="nearest_city" name="nearest_city"
                           value="{{ old('nearest_city', $place->nearest_city) }}" required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $place->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="best_suited_for" class="form-label">Best Suited For</label>
                    <input type="text" class="form-control" id="best_suited_for" name="best_suited_for"
                           value="{{ old('best_suited_for', $place->best_suited_for) }}" required>
                </div>

                <div class="form-group">
                    <label for="activities_offered" class="form-label">Activities Offered</label>
                    <input type="text" class="form-control" id="activities_offered" name="activities_offered"
                           value="{{ old('activities_offered', $place->activities_offered) }}" required>
                </div>

                <div class="form-group">
                    <label for="rating" class="form-label">Rating (1-5)</label>
                    <input type="number" class="form-control" id="rating" name="rating" min="1" max="5"
                           value="{{ old('rating', $place->rating) }}" required>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="pending" {{ old('status', $place->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('status', $place->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ old('status', $place->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.places.user-sent.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
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
