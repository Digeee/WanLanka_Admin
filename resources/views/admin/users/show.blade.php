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
        box-shadow:
          0 18px 50px rgba(2,6,23,.55),
          inset 0 1px 0 rgba(255,255,255,.04);
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

    /* ====== User Details Grid ====== */
    .details-grid{display:grid;gap:24px;grid-template-columns:1fr;}
    @media (min-width:768px){.details-grid{grid-template-columns:1fr 1fr;}}

    .detail-item{margin-bottom:16px;}
    .detail-label{
        font-weight:700;font-size:13px;color:var(--muted);margin-bottom:4px;
        text-transform:uppercase;letter-spacing:0.5px;
    }
    .detail-value{
        font-size:16px;color:var(--text);font-weight:500;
        padding:8px 12px;background:color-mix(in oklab,var(--panel),transparent 4%);
        border-radius:8px;border:1px solid var(--border);
    }

    .image-grid{display:grid;gap:24px;grid-template-columns:1fr;}
    @media (min-width:768px){.image-grid{grid-template-columns:1fr 1fr;}}

    .image-container{text-align:center;}
    .image-label{
        font-weight:700;font-size:13px;color:var(--muted);margin-bottom:12px;
        display:block;
    }
    .user-image{
        width:180px;height:180px;object-fit:cover;border-radius:12px;
        border:1px solid var(--border);box-shadow:var(--shadow-1);
        margin:0 auto;
    }

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
</style>

<div class="shell">
    <div class="page-header">
        <div>
            <div class="breadcrumbs">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
                <a href="{{ route('admin.users.index') }}">Users</a> /
                <span>Show</span>
            </div>
            <h1 class="title">User Details #{{ $user->id }}</h1>
        </div>
        <div class="actions">
            <button type="button" id="themeToggle" class="btn btn-primary">Theme</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Back</a>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">User Information</div>
        <div class="panel-body">
            <div class="details-grid">
                <div>
                    <div class="detail-item">
                        <div class="detail-label">Name</div>
                        <div class="detail-value">{{ $user->name }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Email</div>
                        <div class="detail-value">{{ $user->email }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Date of Birth</div>
                        <div class="detail-value">{{ $user->dob ? $user->dob->format('Y-m-d') : 'N/A' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Address</div>
                        <div class="detail-value">{{ $user->address ?? 'N/A' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">City</div>
                        <div class="detail-value">{{ $user->city ?? 'N/A' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">District</div>
                        <div class="detail-value">{{ $user->district ?? 'N/A' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Province</div>
                        <div class="detail-value">{{ $user->province ?? 'N/A' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Country</div>
                        <div class="detail-value">{{ $user->country ?? 'N/A' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Phone</div>
                        <div class="detail-value">{{ $user->phone ?? 'N/A' }}</div>
                    </div>
                </div>

                <div>
                    <div class="detail-item">
                        <div class="detail-label">Emergency Contact Name</div>
                        <div class="detail-value">{{ $user->emergency_name ?? 'N/A' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Emergency Contact Phone</div>
                        <div class="detail-value">{{ $user->emergency_phone ?? 'N/A' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">ID Type</div>
                        <div class="detail-value">{{ $user->id_type ?? 'N/A' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">ID Number</div>
                        <div class="detail-value">{{ $user->id_number ?? 'N/A' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Preferred Language</div>
                        <div class="detail-value">{{ $user->preferred_language ?? 'N/A' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Marketing Opt-In</div>
                        <div class="detail-value">{{ $user->marketing_opt_in ? 'Yes' : 'No' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Accept Terms</div>
                        <div class="detail-value">{{ $user->accept_terms ? 'Yes' : 'No' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Verified</div>
                        <div class="detail-value">{{ $user->is_verified ? 'Yes' : 'No' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Created At</div>
                        <div class="detail-value">{{ $user->created_at->format('Y-m-d H:i:s') }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Updated At</div>
                        <div class="detail-value">{{ $user->updated_at->format('Y-m-d H:i:s') }}</div>
                    </div>
                </div>
            </div>

            <div class="image-grid" style="margin-top:24px;">
                <div class="image-container">
                    <span class="image-label">Profile Photo</span>
                    <img src="{{ $user->profile_photo_url }}" alt="Profile" class="user-image">
                </div>
                <div class="image-container">
                    <span class="image-label">ID Image</span>
                    @if($user->id_image)
                        <img src="{{ $user->id_image_url }}" alt="ID" class="user-image">
                    @else
                        <div class="detail-value" style="padding:40px;margin:0 auto;max-width:180px;">
                            N/A
                        </div>
                    @endif
                </div>
            </div>

            <div class="actions" style="margin-top:24px;justify-content:center;">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">Edit User</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-neutral">Back to Users</a>
            </div>
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
