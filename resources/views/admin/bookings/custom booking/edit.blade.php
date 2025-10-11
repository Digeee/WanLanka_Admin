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

    /* Panel */
    .panel{ background:var(--panel); border:1px solid var(--border); border-radius:var(--radius); box-shadow:var(--shadow-1); overflow:hidden; }
    .panel-body{ padding:24px; }

    /* Alerts */
    .alert{ border-radius:12px; padding:12px 14px; font-weight:700; margin-bottom:20px; }
    .alert-danger{ color:#b91c1c; background:#fef2f2; border:1px solid #fecaca; }
    [data-theme="dark"] .alert-danger{ color:#fca5a5; background:rgba(185,28,28,.15); border:1px solid #7f1d1d; }

    /* Form */
    .form-group{ margin-bottom:20px; }
    label{ display:block; margin-bottom:8px; font-weight:700; color:var(--text); }
    .form-control{
        width:100%; padding:12px 14px;
        border:1px solid var(--border);
        border-radius:10px;
        background:var(--panel);
        color:var(--text);
        font-size:15px;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
        transition: border-color .2s ease, box-shadow .2s ease;
    }
    .form-control:focus{
        outline:none;
        border-color:var(--accent);
        box-shadow: 0 0 0 3px color-mix(in oklab, var(--accent), transparent 60%);
    }
    .form-control-file{
        padding:6px 0;
        border:none;
        background:transparent;
        color:var(--text);
    }

    /* Form Row */
    .form-row{
        display:grid;
        grid-template-columns: 1fr 1fr;
        gap:20px;
    }
    @media (max-width: 768px){
        .form-row{ grid-template-columns: 1fr; }
    }

    /* Form Actions */
    .form-actions{
        display:flex; gap:15px; margin-top:30px;
        padding-top:20px;
        border-top:1px solid var(--border);
    }
    @media (max-width: 768px){
        .form-actions{
            flex-direction:column;
        }
        .form-actions .btn{
            width:100%;
            justify-content:center;
        }
    }

    /* Image Preview */
    .image-preview{ margin-bottom:15px; }
    .image-preview img{
        max-width:200px; height:auto;
        border-radius:10px;
        border:1px solid var(--border);
        box-shadow: var(--shadow-1);
    }

    /* Tag Input */
    .tag-input-container{
        border:1px solid var(--border);
        border-radius:10px;
        padding:12px;
        background:var(--panel);
        min-height:56px;
    }
    .tag-item{
        display:flex; margin-bottom:10px; align-items:center;
    }
    .tag-item:last-child{ margin-bottom:0; }
    .tag-input{
        flex:1;
        padding:10px 12px;
        border:1px solid var(--border);
        border-radius:8px;
        background:var(--panel);
        color:var(--text);
        font-size:14px;
    }
    .tag-input:focus{
        outline:none;
        border-color:var(--accent);
        box-shadow: 0 0 0 3px color-mix(in oklab, var(--accent), transparent 60%);
    }
    .tag-remove, .tag-add{
        width:32px; height:32px;
        border:1px solid var(--border);
        background:var(--panel);
        border-radius:8px;
        cursor:pointer;
        display:flex; align-items:center; justify-content:center;
        font-weight:800;
        margin-left:8px;
        transition: all .2s ease;
    }
    .tag-remove:hover{
        background:#fee2e2;
        color:#ef4444;
        border-color:#fecaca;
    }
    .tag-add:hover{
        background:#dcfce7;
        color:#16a34a;
        border-color:#bbf7d0;
    }
    [data-theme="dark"] .tag-input{
        background:#1e293b;
    }
    [data-theme="dark"] .tag-remove,
    [data-theme="dark"] .tag-add{
        background:#1e293b;
    }
</style>

<div class="shell" id="custom-package-edit-root">
    <div class="page-header">
        <div>
            <div class="breadcrumbs">
                <a href="{{ route('admin.custom-packages.index') }}">Custom Packages</a> / <span>Edit</span>
            </div>
            <h1 class="title">Edit Custom Package</h1>
        </div>
        <div class="actions">
            <button class="btn" id="themeToggle" type="button">Theme</button>
            <a href="{{ route('admin.custom-packages.index') }}" class="btn">Back</a>
        </div>
    </div>

    <div class="panel">
        <div class="panel-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin:0; padding-left:20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.custom-packages.update', $customPackage) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="user_id">User</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">Select User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $customPackage->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="guider_id">Guider (Optional)</label>
                    <select name="guider_id" id="guider_id" class="form-control">
                        <option value="">Select Guider</option>
                        @foreach ($guiders as $guider)
                            <option value="{{ $guider->id }}" {{ old('guider_id', $customPackage->guider_id) == $guider->id ? 'selected' : '' }}>
                                {{ $guider->first_name }} {{ $guider->last_name }} ({{ $guider->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $customPackage->title) }}" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $customPackage->description) }}</textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="start_location">Start Location</label>
                        <input type="text" name="start_location" id="start_location" class="form-control" value="{{ old('start_location', $customPackage->start_location) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration (days)</label>
                        <input type="number" name="duration" id="duration" class="form-control" value="{{ old('duration', $customPackage->duration) }}" min="1" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="num_people">Number of People</label>
                        <input type="number" name="num_people" id="num_people" class="form-control" value="{{ old('num_people', $customPackage->num_people) }}" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="travel_date">Travel Date</label>
                        <input type="date" name="travel_date" id="travel_date" class="form-control" value="{{ old('travel_date', $customPackage->travel_date ? $customPackage->travel_date->format('Y-m-d') : '') }}">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Price (LKR)</label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $customPackage->price) }}" step="0.01" min="0">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="pending" {{ old('status', $customPackage->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status', $customPackage->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('status', $customPackage->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="active" {{ old('status', $customPackage->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $customPackage->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                
                <!-- Destinations Section -->
                <div class="form-group">
                    <label for="destinations">Destinations</label>
                    <div class="tag-input-container" id="destinations-container">
                        @if(is_array($customPackage->destinations))
                            @foreach($customPackage->destinations as $destination)
                                @if(!is_null($destination) && !empty(trim($destination)))
                                    <div class="tag-item">
                                        <input type="text" name="destinations[]" class="tag-input" value="{{ $destination }}">
                                        <button type="button" class="tag-remove">×</button>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        <div class="tag-item">
                            <input type="text" name="destinations[]" class="tag-input" placeholder="Add destination...">
                            <button type="button" class="tag-add">+</button>
                        </div>
                    </div>
                </div>
                
                <!-- Vehicles Section -->
                <div class="form-group">
                    <label for="vehicles">Vehicles</label>
                    <div class="tag-input-container" id="vehicles-container">
                        @if(is_array($customPackage->vehicles))
                            @foreach($customPackage->vehicles as $vehicle)
                                @if(!is_null($vehicle) && !empty(trim($vehicle)))
                                    <div class="tag-item">
                                        <input type="text" name="vehicles[]" class="tag-input" value="{{ $vehicle }}">
                                        <button type="button" class="tag-remove">×</button>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        <div class="tag-item">
                            <input type="text" name="vehicles[]" class="tag-input" placeholder="Add vehicle...">
                            <button type="button" class="tag-add">+</button>
                        </div>
                    </div>
                </div>
                
                <!-- Accommodations Section -->
                <div class="form-group">
                    <label for="accommodations">Accommodations</label>
                    <div class="tag-input-container" id="accommodations-container">
                        @if(is_array($customPackage->accommodations))
                            @foreach($customPackage->accommodations as $accommodation)
                                @if(!is_null($accommodation) && !empty(trim($accommodation)))
                                    <div class="tag-item">
                                        <input type="text" name="accommodations[]" class="tag-input" value="{{ $accommodation }}">
                                        <button type="button" class="tag-remove">×</button>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        <div class="tag-item">
                            <input type="text" name="accommodations[]" class="tag-input" placeholder="Add accommodation...">
                            <button type="button" class="tag-add">+</button>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="image">Image</label>
                    @if ($customPackage->image)
                        <div class="image-preview">
                            <img src="{{ asset('storage/' . $customPackage->image) }}" alt="Package Image">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="form-control-file">
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Package</button>
                    <a href="{{ route('admin.custom-packages.index') }}" class="btn">Cancel</a>
                </div>
            </form>
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

    // Tag input functionality
    document.addEventListener('DOMContentLoaded', function() {
        function initializeTagInput(containerId) {
            const container = document.getElementById(containerId);
            if (!container) return;
            
            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('tag-add')) {
                    const tagItem = e.target.closest('.tag-item');
                    const input = tagItem.querySelector('.tag-input');
                    const value = input.value.trim();
                    
                    if (value) {
                        const newTagItem = document.createElement('div');
                        newTagItem.className = 'tag-item';
                        newTagItem.innerHTML = `
                            <input type="text" name="${input.name}" class="tag-input" value="${value}">
                            <button type="button" class="tag-remove">×</button>
                        `;
                        container.insertBefore(newTagItem, tagItem);
                        input.value = '';
                    }
                }
                
                if (e.target.classList.contains('tag-remove')) {
                    const tagItem = e.target.closest('.tag-item');
                    tagItem.remove();
                }
            });
            
            container.addEventListener('keypress', function(e) {
                if (e.target.classList.contains('tag-input') && e.key === 'Enter') {
                    e.preventDefault();
                    const tagItem = e.target.closest('.tag-item');
                    const addButton = tagItem.querySelector('.tag-add');
                    addButton?.click();
                }
            });
        }
        
        ['destinations-container', 'vehicles-container', 'accommodations-container'].forEach(id => {
            initializeTagInput(id);
        });
    });
</script>
@endsection