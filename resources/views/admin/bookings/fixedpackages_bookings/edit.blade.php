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
    /* Dark theme header = same look as your screenshot */
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
    .file-wrap{display:grid;gap:8px;}
    input[type="file"].field{padding:10px;}

    .checks{display:grid;gap:10px;}
    .form-check{display:flex;align-items:center;gap:10px;}
    .form-check-input{
        width:18px;height:18px;border-radius:6px;appearance:none;border:1.5px solid var(--ring);
        background:var(--panel);display:inline-grid;place-items:center;cursor:pointer;
        transition:border-color .2s ease,background-color .2s ease,box-shadow .2s ease;
    }
    .form-check-input:checked{
        background:color-mix(in oklab,var(--accent),#000 8%);
        border-color:color-mix(in oklab,var(--accent),#000 18%);
        box-shadow:0 0 0 2px color-mix(in oklab,var(--accent),transparent 75%);
    }
    .form-check-label{color:var(--text);font-weight:700;}

    .alert{border-radius:12px;padding:12px 14px;font-weight:700;}
    .alert-success{color:#065f46;background:#ecfdf5;border:1px solid #a7f3d0;}
    [data-theme="dark"] .alert-success{color:#bbf7d0;background:rgba(6,95,70,.15);border:1px solid #134e4a;}
    .alert-danger{color:#7f1d1d;background:#fee2e2;border:1px solid #fecaca;}
    [data-theme="dark"] .alert-danger{color:#fecaca;background:rgba(127,29,29,.2);border:1px solid #7f1d1d;}

    /* ====== Your glossy pill buttons (outline glow + shine) ====== */
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
    [data-theme="dark"] .btn-primary{
        --fg:color-mix(in oklab,var(--accent),white 45%);
        --bd:color-mix(in oklab,var(--accent),white 18%);
        --fill:color-mix(in oklab,var(--panel),transparent 10%);
    }

    .btn-neutral{
        --fg:color-mix(in oklab,var(--muted),#000 10%);
        --bd:var(--ring);
        --fill:color-mix(in oklab,var(--panel),transparent 12%);
        backdrop-filter:var(--glass);
    }
    .btn-neutral:hover{--fill:color-mix(in oklab,var(--panel),transparent 0%);--fg:var(--text);}
    [data-theme="dark"] .btn-neutral{--fg:color-mix(in oklab,var(--text),white 20%);--fill:color-mix(in oklab,var(--panel),transparent 14%);}

    .btn-danger{
        --fg:color-mix(in oklab,var(--danger),#000 25%);
        --bd:color-mix(in oklab,var(--danger),#000 18%);
        --fill:color-mix(in oklab,var(--panel),transparent 0%);
    }
    .btn-danger:hover{
        color:#fff;text-shadow:0 1px 0 rgba(0,0,0,.25);
        background-image:
          var(--shine),
          linear-gradient(180deg,color-mix(in oklab,var(--danger),#000 8%),var(--danger)),
          linear-gradient(135deg,color-mix(in oklab,var(--danger),#000 18%),color-mix(in oklab,var(--danger),#000 28%));
        border-color:transparent;box-shadow:0 14px 30px rgba(239,68,68,.35);
    }
</style>

<div class="shell">
    <div class="page-header">
        <div>
            <div class="breadcrumbs">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
                <a href="{{ route('admin.fixedpackage.bookings.index') }}">Fixed Package Bookings</a> /
                <span>Edit</span>
            </div>
            <h1 class="title">Edit Fixed Package Booking #{{ $booking->id }}</h1>
        </div>
        <div class="actions">
            <button type="button" id="themeToggle" class="btn btn-primary">Theme</button>
            <a href="{{ route('admin.fixedpackage.bookings.index') }}" class="btn btn-primary">Back</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
        <div class="panel-header">Update Booking Details</div>
        <div class="panel-body">
            <form action="{{ route('admin.fixedpackage.bookings.update', $booking->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid split">
                    <div>
                        <label for="package_name" class="form-label">Package Name</label>
                        <input type="text" class="field" id="package_name" name="package_name" value="{{ $booking->package_name ?? '' }}" disabled>
                    </div>
                    <div>
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="field" id="first_name" name="first_name" value="{{ $booking->first_name }}" required>
                    </div>
                </div>

                <div class="form-grid split">
                    <div>
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="field" id="last_name" name="last_name" value="{{ $booking->last_name }}" required>
                    </div>
                    <div>
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="field" id="email" name="email" value="{{ $booking->email }}" required>
                    </div>
                </div>

                <div class="form-grid split">
                    <div>
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="field" id="phone" name="phone" value="{{ $booking->phone }}" required>
                    </div>
                    <div>
                        <label for="pickup_location" class="form-label">Pickup Location</label>
                        <input type="text" class="field" id="pickup_location" name="pickup_location" value="{{ $booking->pickup_location }}" required>
                    </div>
                </div>

                <div class="form-grid split">
                    <div>
                        <label for="participants" class="form-label">Number of Participants</label>
                        <input type="number" class="field" id="participants" name="participants" value="{{ $booking->participants }}" min="1" required>
                    </div>
                    <div>
                        <label for="total_price" class="form-label">Total Price ($)</label>
                        <input type="number" step="0.01" class="field" id="total_price" name="total_price" value="{{ $booking->total_price }}" required>
                    </div>
                </div>

                <div class="form-grid split">
                    <div>
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select class="field" id="payment_method" name="payment_method" required>
                            <option value="credit_card" {{ $booking->payment_method == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            <option value="paypal" {{ $booking->payment_method == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            <option value="bank_transfer" {{ $booking->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="cash" {{ $booking->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                        </select>
                    </div>
                    <div>
                        <label for="receipt" class="form-label">Receipt</label>
                        <input type="text" class="field" id="receipt" name="receipt" value="{{ $booking->receipt ?? '' }}">
                    </div>
                </div>

                <div class="form-grid split">
                    <div>
                        <label for="vehicle_id" class="form-label">Assign Vehicle</label>
                        <select class="field" id="vehicle_id" name="vehicle_id">
                            <option value="">Select Vehicle</option>
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" {{ $booking->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle->vehicle_type }} ({{ $vehicle->seat_count }} seats, {{ $vehicle->number_plate }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="guider_id" class="form-label">Assign Guider</label>
                        <select class="field" id="guider_id" name="guider_id">
                            <option value="">Select Guider</option>
                            @foreach($guiders as $guider)
                                <option value="{{ $guider->id }}" {{ $booking->guider_id == $guider->id ? 'selected' : '' }}>
                                    {{ $guider->first_name }} {{ $guider->last_name }} ({{ $guider->email }}) - Specializations: {{ $guider->specializations ? implode(', ', $guider->specializations) : 'None' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-grid split">
                    <div>
                        <label for="status" class="form-label">Status</label>
                        <select class="field" id="status" name="status" required>
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                </div>

                <div class="actions" style="margin-top:18px;">
                    <button type="submit" class="btn btn-primary">Update Booking</button>
                    <a href="{{ route('admin.fixedpackage.bookings.index') }}" class="btn btn-neutral">Cancel</a>
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
</script>
@endsection
