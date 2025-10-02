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
    .alert-danger{ color:#991b1b; background:#fef2f2; border:1px solid #fecaca; }
    [data-theme="dark"] .alert-danger{ color:#fca5a5; background:rgba(153,27,27,.15); border:1px solid #7f1d1d; }

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

    .form-check-input{
        width:18px; height:18px; margin-top:4px; accent-color: var(--accent);
    }

    /* Action Buttons */
    .form-actions{ display:flex; gap:12px; margin-top:24px; flex-wrap:wrap; }
</style>

<div class="shell" id="user-create-root">
    <div class="page-header">
        <div>
            <div class="breadcrumbs">
                <a href="{{ route('admin.users.index') }}">Users</a> / <span>Create</span>
            </div>
            <h1 class="title">Add New User</h1>
        </div>
        <div class="actions">
            <button class="btn btn-primary" id="themeToggle" type="button">Theme</button>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel">
        <div class="panel-header">User Information</div>
        <div class="panel-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="form-group">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}">
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                </div>

                <div class="form-group">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                </div>

                <div class="form-group">
                    <label for="district" class="form-label">District</label>
                    <select class="form-select" id="district" name="district">
                        <option value="">Select District</option>
                        @foreach([
                            'Colombo','Gampaha','Kalutara','Kandy','Matale','Nuwara Eliya',
                            'Galle','Matara','Hambantota','Jaffna','Mannar','Vavuniya',
                            'Mullaitivu','Kilinochchi','Batticaloa','Ampara','Trincomalee',
                            'Kurunegala','Puttalam','Anuradhapura','Polonnaruwa','Badulla',
                            'Monaragala','Ratnapura','Kegalle'
                        ] as $dist)
                            <option value="{{ $dist }}" {{ old('district') == $dist ? 'selected' : '' }}>{{ $dist }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="province" class="form-label">Province</label>
                    <input type="text" class="form-control" id="province" name="province" value="{{ old('province') }}">
                </div>

                <div class="form-group">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}">
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                </div>

                <div class="form-group">
                    <label for="emergency_name" class="form-label">Emergency Contact Name</label>
                    <input type="text" class="form-control" id="emergency_name" name="emergency_name" value="{{ old('emergency_name') }}">
                </div>

                <div class="form-group">
                    <label for="emergency_phone" class="form-label">Emergency Contact Phone</label>
                    <input type="text" class="form-control" id="emergency_phone" name="emergency_phone" value="{{ old('emergency_phone') }}">
                </div>

                <div class="form-group">
                    <label for="id_type" class="form-label">ID Type</label>
                    <select class="form-select" id="id_type" name="id_type">
                        <option value="">Select ID Type</option>
                        <option value="NIC" {{ old('id_type') == 'NIC' ? 'selected' : '' }}>NIC</option>
                        <option value="Passport" {{ old('id_type') == 'Passport' ? 'selected' : '' }}>Passport</option>
                        <option value="Driving License" {{ old('id_type') == 'Driving License' ? 'selected' : '' }}>Driving License</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_number" class="form-label">ID Number</label>
                    <input type="text" class="form-control" id="id_number" name="id_number" value="{{ old('id_number') }}">
                </div>

                <div class="form-group">
                    <label for="preferred_language" class="form-label">Preferred Language</label>
                    <select class="form-select" id="preferred_language" name="preferred_language">
                        <option value="">Select Language</option>
                        <option value="English" {{ old('preferred_language') == 'English' ? 'selected' : '' }}>English</option>
                        <option value="Tamil" {{ old('preferred_language') == 'Tamil' ? 'selected' : '' }}>Tamil</option>
                        <option value="Sinhala" {{ old('preferred_language') == 'Sinhala' ? 'selected' : '' }}>Sinhala</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label d-block">Preferences</label>
                    <div style="display:flex; gap:24px; flex-wrap:wrap;">
                        <div class="form-check" style="display:flex; align-items:center; gap:8px;">
                            <input type="checkbox" class="form-check-input" id="marketing_opt_in" name="marketing_opt_in" value="1" {{ old('marketing_opt_in') ? 'checked' : '' }}>
                            <label class="form-check-label" for="marketing_opt_in">Marketing Opt-In</label>
                        </div>
                        <div class="form-check" style="display:flex; align-items:center; gap:8px;">
                            <input type="checkbox" class="form-check-input" id="accept_terms" name="accept_terms" value="1" {{ old('accept_terms') ? 'checked' : '' }}>
                            <label class="form-check-label" for="accept_terms">Accept Terms</label>
                        </div>
                        <div class="form-check" style="display:flex; align-items:center; gap:8px;">
                            <input type="checkbox" class="form-check-input" id="is_verified" name="is_verified" value="1" {{ old('is_verified') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_verified">Verified</label>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Create User</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
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
