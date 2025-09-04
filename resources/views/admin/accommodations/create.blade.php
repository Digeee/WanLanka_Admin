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

    /* ====== Shell & BG ====== */
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
    .actions{display:flex;gap:10px;flex-wrap:wrap;}

    /* ====== Panel ====== */
    .panel{background:var(--panel);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-1);overflow:hidden;}
    .panel-header{
        padding:14px 16px;border-bottom:1px solid var(--border);font-weight:800;
        background:
          linear-gradient(180deg,color-mix(in oklab,var(--panel),transparent 92%),transparent),
          radial-gradient(1000px 100px at 0 -30%,color-mix(in oklab,var(--accent),transparent 92%),transparent);
    }
    .panel-body{padding:18px;}

    /* ====== Form ====== */
    .form-grid{display:grid;gap:14px;}
    .row{display:grid;gap:14px;}
    @media(min-width:800px){ .row{grid-template-columns:1fr 1fr;} }
    .form-group{display:flex;flex-direction:column;gap:8px;}
    label{font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--muted);font-weight:800;}
    .form-control, .form-control-file, textarea, select{
        width:100%; padding:12px 14px; border-radius:12px;
        border:1px solid var(--border); background:color-mix(in oklab,var(--panel),transparent 6%);
        color:var(--text); box-shadow:none; outline:none; transition: box-shadow .15s ease, border-color .15s ease, background-color .15s ease;
    }
    textarea{min-height:110px; resize:vertical;}
    .form-control:focus, textarea:focus, select:focus{
        border-color:color-mix(in oklab,var(--accent),#000 20%);
        box-shadow:0 0 0 3px color-mix(in oklab,var(--accent),transparent 75%), var(--shadow-1);
        background:color-mix(in oklab,var(--panel),transparent 0%);
    }
    .alert{border-radius:12px;padding:12px 14px;font-weight:700;margin:14px 0;}
    .alert-danger{color:#7f1d1d;background:#fee2e2;border:1px solid #fecaca;}
    [data-theme="dark"] .alert-danger{color:#fecaca;background:rgba(127,29,29,.15);border:1px solid #7f1d1d;}

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
    .btn-neutral{
        --fg:color-mix(in oklab,var(--muted),#000 10%);
        --bd:var(--ring);
        --fill:color-mix(in oklab,var(--panel),transparent 12%);
        backdrop-filter:var(--glass);
    }
    .btn-neutral:hover{--fill:color-mix(in oklab,var(--panel),transparent 0%);--fg:var(--text);}
    .mt-2{margin-top:12px;}
</style>

<div class="shell">
    <!-- Header -->
    <div class="page-header">
        <div>
            <div class="breadcrumbs"><a href="{{ route('admin.accommodations.index') }}">Accommodations</a> / <span>Create</span></div>
            <h1 class="title">Add New Accommodation</h1>
        </div>
        <div class="actions">
            <!-- NEW Back button -->
            <a href="{{ route('admin.accommodations.index') }}" class="btn btn-neutral" aria-label="Back to list">← Back</a>
            <button id="themeToggle" type="button" class="btn btn-primary">Theme</button>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel">
        <div class="panel-header"><strong>Accommodation Details</strong></div>
        <div class="panel-body">
            <form action="{{ route('admin.accommodations.store') }}" method="POST" enctype="multipart/form-data" class="form-grid">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="form-group" style="grid-column:1/-1;">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="province">Province</label>
                        <select name="province" id="province" class="form-control" required>
                            <option value="" disabled {{ old('province') ? '' : 'selected' }}>Select Province</option>
                            <option value="Northern" {{ old('province') == 'Northern' ? 'selected' : '' }}>Northern</option>
                            <option value="North Western" {{ old('province') == 'North Western' ? 'selected' : '' }}>North Western</option>
                            <option value="Western" {{ old('province') == 'Western' ? 'selected' : '' }}>Western</option>
                            <option value="North Central" {{ old('province') == 'North Central' ? 'selected' : '' }}>North Central</option>
                            <option value="Central" {{ old('province') == 'Central' ? 'selected' : '' }}>Central</option>
                            <option value="Sabaragamuwa" {{ old('province') == 'Sabaragamuwa' ? 'selected' : '' }}>Sabaragamuwa</option>
                            <option value="Eastern" {{ old('province') == 'Eastern' ? 'selected' : '' }}>Eastern</option>
                            <option value="Uva" {{ old('province') == 'Uva' ? 'selected' : '' }}>Uva</option>
                            <option value="Southern" {{ old('province') == 'Southern' ? 'selected' : '' }}>Southern</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="district">District</label>
                        <select name="district" id="district" class="form-control" required>
                            <option value="" disabled selected>Select District</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" style="grid-column:1/-1;">
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}">
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="number" name="latitude" id="latitude" class="form-control" value="{{ old('latitude') }}" step="0.00000001" min="-90" max="90">
                    </div>
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="number" name="longitude" id="longitude" class="form-control" value="{{ old('longitude') }}" step="0.00000001" min="-180" max="180">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="price_per_night">Price Per Night</label>
                        <input type="number" name="price_per_night" id="price_per_night" class="form-control" value="{{ old('price_per_night', 0) }}" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="rating">Rating (0-5)</label>
                        <input type="number" name="rating" id="rating" class="form-control" value="{{ old('rating') }}" step="0.1" min="0" max="5">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="room_types">Room Types (comma-separated)</label>
                        <input type="text" name="room_types[]" id="room_types" class="form-control" value="{{ old('room_types') ? implode(',', old('room_types')) : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="amenities">Amenities (comma-separated)</label>
                        <input type="text" name="amenities[]" id="amenities" class="form-control" value="{{ old('amenities') ? implode(',', old('amenities')) : '' }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control-file">
                    </div>
                    <div class="form-group">
                        <label for="reviews">Reviews (comma-separated)</label>
                        <input type="text" name="reviews[]" id="reviews" class="form-control" value="{{ old('reviews') ? implode(',', old('reviews')) : '' }}">
                    </div>
                </div>

                <div class="actions mt-2" style="justify-content:space-between;">
                    <a href="{{ route('admin.accommodations.index') }}" class="btn btn-neutral">← Back</a>
                    <div class="actions" style="gap:10px;">
                        <a href="{{ route('admin.accommodations.index') }}" class="btn btn-neutral">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Accommodation</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Province -> District linkage
    const provinceDistricts = {
        'Northern': ['Jaffna', 'Kilinochchi', 'Mannar', 'Mullaitivu', 'Vavuniya'],
        'North Western': ['Puttalam', 'Kurunegala'],
        'Western': ['Gampaha', 'Colombo', 'Kalutara'],
        'North Central': ['Anuradhapura', 'Polonnaruwa'],
        'Central': ['Matale', 'Kandy', 'Nuwara Eliya'],
        'Sabaragamuwa': ['Kegalle', 'Ratnapura'],
        'Eastern': ['Trincomalee', 'Batticaloa', 'Ampara'],
        'Uva': ['Badulla', 'Monaragala'],
        'Southern': ['Hambantota', 'Matara', 'Galle']
    };

    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');

    provinceSelect.addEventListener('change', function () {
        const selectedProvince = this.value;
        districtSelect.innerHTML = '<option value="" disabled selected>Select District</option>';
        if (selectedProvince && provinceDistricts[selectedProvince]) {
            provinceDistricts[selectedProvince].forEach(d => {
                const o = document.createElement('option');
                o.value = d; o.textContent = d;
                districtSelect.appendChild(o);
            });
        }
    });

    if (provinceSelect.value) {
        provinceSelect.dispatchEvent(new Event('change'));
    }

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
