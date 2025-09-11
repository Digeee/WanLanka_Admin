@extends('admin.layouts.master')

@section('content')
<style>
    /* ====== Design Tokens (Light / Dark) ====== */
    :root{
        --bg:#f8fafc; --panel:#ffffff; --muted:#64748b; --text:#0f172a;
        --border:#e2e8f0; --ring:#3b82f6; --accent:#3b82f6; --accent-2:#22c55e;
        --danger:#ef4444; --warning:#f59e0b; --radius:16px;
        --shadow-1:0 2px 4px rgba(0,0,0,.04),0 4px 6px rgba(0,0,0,.06);
    }
    [data-theme="dark"]{
        --bg:#0b1220; --panel:#111827; --muted:#9ca3af; --text:#f3f4f6;
        --border:#1f2937; --ring:#60a5fa; --accent:#60a5fa; --accent-2:#34d399;
        --danger:#f87171; --warning:#fbbf24;
        --shadow-1:0 2px 6px rgba(0,0,0,.55);
    }

    body{background:var(--bg);}
    .shell{max-width:1000px;margin:28px auto 80px;padding:0 20px;color:var(--text);}

    /* ====== Page Header ====== */
    .page-header{
        display:flex;align-items:center;justify-content:space-between;
        background:var(--panel);
        border:1px solid var(--border);
        border-radius:20px;
        padding:20px 24px;
        box-shadow:var(--shadow-1);
        margin-bottom:24px;
    }
    .breadcrumbs{font-size:14px;color:var(--muted);margin-bottom:4px;}
    .breadcrumbs a{color:inherit;text-decoration:none;}
    .title{margin:0;font-size:24px;font-weight:800;}
    .actions{display:flex;gap:12px;flex-wrap:wrap;}

    /* ====== Buttons (outlined pill style) ====== */
    .btn{
        display:inline-flex;align-items:center;justify-content:center;
        padding:8px 18px;
        border-radius:999px;
        font-weight:700;font-size:14px;
        text-decoration:none;cursor:pointer;
        transition:all .25s ease;
        border:1.5px solid var(--ring);
        background:transparent;
        color:var(--ring);
    }
    .btn:hover{
        background:var(--ring);
        color:#fff;
        box-shadow:0 4px 12px rgba(59,130,246,.25);
    }

    /* ====== Form Panel ====== */
    .panel{background:var(--panel);border:1px solid var(--border);
        border-radius:var(--radius);box-shadow:var(--shadow-1);padding:24px;}

    .form-group{margin-bottom:18px;}
    label{font-weight:600;margin-bottom:6px;display:block;color:var(--text);}
    .form-control,.form-control-file,textarea,select{
        width:100%;padding:12px;border-radius:12px;border:1px solid var(--border);
        background:var(--panel);box-shadow:inset 0 1px 2px rgba(0,0,0,.04);
        font-size:14px;color:var(--text);
    }
    .form-control:focus,textarea:focus,select:focus{
        outline:none;border-color:var(--accent);
        box-shadow:0 0 0 3px color-mix(in oklab,var(--accent),transparent 70%);
    }

    /* Alerts */
    .alert{border-radius:12px;padding:12px 14px;font-weight:700;margin-bottom:18px;}
    .alert-danger{color:#991b1b;background:#fee2e2;border:1px solid #fecaca;}
    [data-theme="dark"] .alert-danger{color:#fecaca;background:rgba(239,68,68,.15);border:1px solid #7f1d1d;}

    /* Day plan box */
    .day-plan{padding:16px;margin-bottom:15px;border-radius:14px;
        background:color-mix(in oklab,var(--panel),transparent 8%);border:1px solid var(--border);}
</style>

<div class="shell">
    {{-- Page header --}}
    <div class="page-header">
        <div>
            <div class="breadcrumbs"><a href="{{ route('admin.packages.index') }}">Packages</a> / <span>Create</span></div>
            <h1 class="title">Add New Package</h1>
        </div>
        <div class="actions">
            <button type="button" id="themeToggle" class="btn">Theme</button>
            <a href="{{ route('admin.packages.index') }}" class="btn">Back</a>
        </div>
    </div>

    {{-- Form --}}
    <div class="panel">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="package_name">Package Name</label>
                <input type="text" name="package_name" id="package_name" class="form-control" value="{{ old('package_name') }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="price">Base Price</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" step="0.01" min="0">
            </div>
            <div class="form-group">
                <label for="cover_image">Cover Image</label>
                <input type="file" name="cover_image" id="cover_image" class="form-control-file">
            </div>
            <div class="form-group">
                <label for="gallery">Gallery (multiple images)</label>
                <input type="file" name="gallery[]" id="gallery" class="form-control-file" multiple>
            </div>
            <div class="form-group">
                <label for="starting_date">Starting Date</label>
                <input type="date" name="starting_date" id="starting_date" class="form-control" value="{{ old('starting_date') }}">
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
            </div>
            <div class="form-group">
                <label for="related_places">Places</label>
                <select name="related_places[]" id="related_places" class="form-control" multiple required>
                    @foreach ($places as $place)
                        <option value="{{ $place->id }}" {{ in_array($place->id, old('related_places', [])) ? 'selected' : '' }}>
                            {{ $place->name }} ({{ $place->province }} - {{ $place->district }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="accommodations">Accommodations</label>
                <select name="accommodations[]" id="accommodations" class="form-control" multiple required>
                    @foreach ($accommodations as $accommodation)
                        <option value="{{ $accommodation->id }}" {{ in_array($accommodation->id, old('accommodations', [])) ? 'selected' : '' }}>
                            {{ $accommodation->name }} ({{ $accommodation->province }} - {{ $accommodation->district }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="days">Number of Days</label>
                <input type="number" name="days" id="days" class="form-control" value="{{ old('days', 1) }}" min="1" required>
            </div>
            <div id="day-plans-container"></div>

            <div class="form-group">
                <label for="inclusions">Inclusions (comma-separated)</label>
                <input type="text" name="inclusions[]" id="inclusions" class="form-control" value="{{ old('inclusions') ? implode(',', old('inclusions')) : '' }}">
            </div>
            <div class="form-group">
                <label for="vehicle_type_id">Vehicle Type</label>
                <select name="vehicle_type_id" id="vehicle_type_id" class="form-control" required>
                    <option value="" {{ old('vehicle_type_id') ? '' : 'selected' }}>Select Vehicle</option>
                    @foreach ($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ old('vehicle_type_id') == $vehicle->id ? 'selected' : '' }}>
                            {{ $vehicle->vehicle_type }} ({{ $vehicle->model }} - {{ $vehicle->number_plate }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="package_type">Package Type</label>
                <select name="package_type" id="package_type" class="form-control" required>
                    <option value="low_budget" {{ old('package_type', 'custom') == 'low_budget' ? 'selected' : '' }}>Low Budget</option>
                    <option value="high_budget" {{ old('package_type', 'custom') == 'high_budget' ? 'selected' : '' }}>High Budget</option>
                    <option value="custom" {{ old('package_type', 'custom') == 'custom' ? 'selected' : '' }}>Custom</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="active" {{ old('status', 'draft') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', 'draft') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="form-group">
                <label for="rating">Rating (0-5)</label>
                <input type="number" name="rating" id="rating" class="form-control" value="{{ old('rating') }}" step="0.1" min="0" max="5">
            </div>
            <div class="form-group">
                <label for="reviews">Reviews (comma-separated)</label>
                <input type="text" name="reviews[]" id="reviews" class="form-control" value="{{ old('reviews') ? implode(',', old('reviews')) : '' }}">
            </div>

            <button type="submit" class="btn">Save Package</button>
            <a href="{{ route('admin.packages.index') }}" class="btn">Cancel</a>
        </form>
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
        if(!saved && window.matchMedia('(prefers-color-scheme: dark)').matches){
            root.setAttribute('data-theme','dark');
        }
    })();

    // Dynamic Day Plans
    const daysInput = document.getElementById('days');
    const dayPlansContainer = document.getElementById('day-plans-container');
    const oldDayPlans = @json(old('day_plans', []));
    const accommodations = @json($accommodations);

    function updateDayPlans() {
        const days = parseInt(daysInput.value) || 1;
        dayPlansContainer.innerHTML = '';

        for (let i = 0; i < days; i++) {
            const dayPlan = oldDayPlans[i] || {};
            const dayPlanDiv = document.createElement('div');
            dayPlanDiv.className = 'day-plan';
            dayPlanDiv.innerHTML = `
                <h4>Day ${i + 1}</h4>
                <div class="form-group">
                    <label for="day_plans[${i}][plan]">Plan</label>
                    <textarea name="day_plans[${i}][plan]" id="day_plans[${i}][plan]" class="form-control">${dayPlan.plan || ''}</textarea>
                </div>
                <div class="form-group">
                    <label for="day_plans[${i}][accommodation_id]">Accommodation</label>
                    <select name="day_plans[${i}][accommodation_id]" id="day_plans[${i}][accommodation_id]" class="form-control">
                        <option value="" ${!dayPlan.accommodation_id ? 'selected' : ''}>Select Accommodation</option>
                        ${accommodations.map(accommodation => `
                            <option value="${accommodation.id}" ${dayPlan.accommodation_id == accommodation.id ? 'selected' : ''}>
                                ${accommodation.name} (${accommodation.province} - ${accommodation.district})
                            </option>
                        `).join('')}
                    </select>
                </div>
                <div class="form-group">
                    <label for="day_plans[${i}][description]">Description</label>
                    <textarea name="day_plans[${i}][description]" id="day_plans[${i}][description]" class="form-control">${dayPlan.description || ''}</textarea>
                </div>
                <div class="form-group">
                    <label for="day_plans[${i}][photos][]">Photos</label>
                    <input type="file" name="day_plans[${i}][photos][]" id="day_plans[${i}][photos]" class="form-control-file" multiple>
                </div>
            `;
            dayPlansContainer.appendChild(dayPlanDiv);
        }
    }

    daysInput.addEventListener('input', updateDayPlans);
    updateDayPlans();
</script>
@endsection
