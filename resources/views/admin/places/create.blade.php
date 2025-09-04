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

    /* ====== Shell & Header ====== */
    .shell{max-width:1100px;margin:28px auto 80px;padding:0 20px;color:var(--text);}
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
    .title{margin:0;font-size:26px;font-weight:800;letter-spacing:.2px;color:var(--text);}
    [data-theme="dark"] .title{color:#f8fafc;text-shadow:0 1px 0 rgba(0,0,0,.45);}
    .actions{display:flex;gap:12px;flex-wrap:wrap;}

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

    .alert{border-radius:12px;padding:12px 14px;font-weight:700;}
    .alert-danger{color:#7f1d1d;background:#fee2e2;border:1px solid #fecaca;}
    [data-theme="dark"] .alert-danger{color:#fecaca;background:rgba(127,29,29,.2);border:1px solid #7f1d1d;}

    /* ====== Glossy pill buttons (your style) ====== */
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
    [data-theme="dark"] .btn-primary{--fg:color-mix(in oklab,var(--accent),white 45%);--bd:color-mix(in oklab,var(--accent),white 18%);--fill:color-mix(in oklab,var(--panel),transparent 10%);}
    .btn-neutral{
        --fg:color-mix(in oklab,var(--muted),#000 10%);
        --bd:var(--ring);
        --fill:color-mix(in oklab,var(--panel),transparent 12%);
        backdrop-filter:var(--glass);
    }
    .btn-neutral:hover{--fill:color-mix(in oklab,var(--panel),transparent 0%);--fg:var(--text);}
    [data-theme="dark"] .btn-neutral{--fg:color-mix(in oklab,var(--text),white 20%);--fill:color-mix(in oklab,var(--panel),transparent 14%);}
</style>

<div class="shell">
    <div class="page-header">
        <div>
            <div class="breadcrumbs"><a href="{{ route('admin.places.index') }}">Places</a> / <span>Create</span></div>
            <h1 class="title">Add New Place</h1>
        </div>
        <div class="actions">
            <button type="button" id="themeToggle" class="btn btn-primary">Theme</button>
            <a href="{{ route('admin.places.index') }}" class="btn btn-primary">Back</a>
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
        <div class="panel-header">Place Details</div>
        <div class="panel-body">
            <form action="{{ route('admin.places.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-grid">
                    <div>
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="field" value="{{ old('name') }}" required>
                    </div>
                </div>

                <div class="form-grid split">
                    <div>
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="field">
                    </div>
                    <div>
                        <label for="location">Location</label>
                        <input type="text" name="location" id="location" class="field" value="{{ old('location') }}">
                    </div>
                </div>

                <div class="form-grid split">
                    <div>
                        <label for="province">Province</label>
                        <select name="province" id="province" class="field" required>
                            <option value="" disabled {{ old('province') ? '' : 'selected' }}>Select Province</option>
                            <option value="Northern"        {{ old('province')=='Northern' ? 'selected':'' }}>Northern</option>
                            <option value="North Western"   {{ old('province')=='North Western' ? 'selected':'' }}>North Western</option>
                            <option value="Western"         {{ old('province')=='Western' ? 'selected':'' }}>Western</option>
                            <option value="North Central"   {{ old('province')=='North Central' ? 'selected':'' }}>North Central</option>
                            <option value="Central"         {{ old('province')=='Central' ? 'selected':'' }}>Central</option>
                            <option value="Sabaragamuwa"    {{ old('province')=='Sabaragamuwa' ? 'selected':'' }}>Sabaragamuwa</option>
                            <option value="Eastern"         {{ old('province')=='Eastern' ? 'selected':'' }}>Eastern</option>
                            <option value="Uva"             {{ old('province')=='Uva' ? 'selected':'' }}>Uva</option>
                            <option value="Southern"        {{ old('province')=='Southern' ? 'selected':'' }}>Southern</option>
                        </select>
                    </div>
                    <div>
                        <label for="district">District</label>
                        <select name="district" id="district" class="field" required>
                            <option value="" disabled selected>Select District</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="field">{{ old('description') }}</textarea>
                </div>

                <div class="form-grid split">
                    <div>
                        <label for="weather">Weather</label>
                        <input type="text" name="weather" id="weather" class="field" value="{{ old('weather') }}">
                    </div>
                    <div>
                        <label for="travel_type">Travel Type</label>
                        <input type="text" name="travel_type" id="travel_type" class="field" value="{{ old('travel_type') }}">
                    </div>
                </div>

                <div class="form-grid split">
                    <div>
                        <label for="season">Season</label>
                        <input type="text" name="season" id="season" class="field" value="{{ old('season') }}">
                    </div>
                    <div class="form-grid split">
                        <div>
                            <label for="latitude">Latitude</label>
                            <input type="number" name="latitude" id="latitude" class="field" value="{{ old('latitude') }}" step="0.00000001" min="-90" max="90">
                        </div>
                        <div>
                            <label for="longitude">Longitude</label>
                            <input type="number" name="longitude" id="longitude" class="field" value="{{ old('longitude') }}" step="0.00000001" min="-180" max="180">
                        </div>
                    </div>
                </div>

                <div class="form-grid split">
                    <div>
                        <label for="gallery">Gallery (multiple images)</label>
                        <input type="file" name="gallery[]" id="gallery" class="field" multiple>
                    </div>
                    <div>
                        <label for="entry_fee">Entry Fee</label>
                        <input type="number" name="entry_fee" id="entry_fee" class="field" value="{{ old('entry_fee', 0) }}" step="0.01" min="0">
                    </div>
                </div>

                <div class="form-grid split">
                    <div>
                        <label for="opening_hours">Opening Hours</label>
                        <input type="text" name="opening_hours" id="opening_hours" class="field" value="{{ old('opening_hours') }}">
                    </div>
                    <div>
                        <label for="best_time_to_visit">Best Time to Visit</label>
                        <input type="text" name="best_time_to_visit" id="best_time_to_visit" class="field" value="{{ old('best_time_to_visit') }}">
                    </div>
                </div>

                <div class="form-grid split">
                    <div>
                        <label for="rating">Rating (0-5)</label>
                        <input type="number" name="rating" id="rating" class="field" value="{{ old('rating') }}" step="0.1" min="0" max="5">
                    </div>
                    <div>
                        <label for="status">Status</label>
                        <select name="status" id="status" class="field" required>
                            <option value="active"   {{ old('status','active')=='active' ? 'selected':'' }}>Active</option>
                            <option value="inactive" {{ old('status','active')=='inactive' ? 'selected':'' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="actions" style="margin-top:18px;">
                    <button type="submit" class="btn btn-primary">Save Place</button>
                    <a href="{{ route('admin.places.index') }}" class="btn btn-neutral">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Theme toggle
    (function(){
        const key='ui-theme';
        const root=document.documentElement;
        const btn=document.getElementById('themeToggle');
        const saved=localStorage.getItem(key);
        if(saved==='dark') root.setAttribute('data-theme','dark');
        btn?.addEventListener('click',()=>{
            const dark=root.getAttribute('data-theme')==='dark';
            root.setAttribute('data-theme', dark ? 'light' : 'dark');
            localStorage.setItem(key, dark ? 'light' : 'dark');
        });
        if(!saved && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches){
            root.setAttribute('data-theme','dark');
        }
    })();

    // Province -> Districts
    const provinceDistricts = {
        'Northern': ['Jaffna','Kilinochchi','Mannar','Mullaitivu','Vavuniya'],
        'North Western': ['Puttalam','Kurunegala'],
        'Western': ['Gampaha','Colombo','Kalutara'],
        'North Central': ['Anuradhapura','Polonnaruwa'],
        'Central': ['Matale','Kandy','Nuwara Eliya'],
        'Sabaragamuwa': ['Kegalle','Ratnapura'],
        'Eastern': ['Trincomalee','Batticaloa','Ampara'],
        'Uva': ['Badulla','Monaragala'],
        'Southern': ['Hambantota','Matara','Galle']
    };

    const provinceSelect = document.getElementById('province');
    const districtSelect  = document.getElementById('district');
    const oldDistrict     = @json(old('district'));

    function rebuildDistricts(){
        const selectedProvince = provinceSelect.value;
        districtSelect.innerHTML = '<option value="" disabled selected>Select District</option>';
        if (selectedProvince && provinceDistricts[selectedProvince]) {
            provinceDistricts[selectedProvince].forEach(d => {
                const opt = document.createElement('option');
                opt.value = d; opt.textContent = d;
                if (oldDistrict && oldDistrict === d) opt.selected = true;
                districtSelect.appendChild(opt);
            });
        }
    }

    provinceSelect.addEventListener('change', rebuildDistricts);
    if (provinceSelect.value) rebuildDistricts();
</script>
@endsection
