@extends('admin.layouts.master')

@section('content')
<style>
/* ====== Base Theme Variables ====== */
:root {
  --panel:#fff;
  --text:#222;
  --muted:#6c757d;
  --border:#e0e6ef;
  --accent:#1a73e8;
  --danger:#d63031;
  --success:#00b894;
  --shadow-1:0 2px 8px rgba(0,0,0,0.05);
}
[data-theme="dark"] {
  --panel:#1f1f28;
  --text:#f5f5f5;
  --muted:#999;
  --border:#333;
  --accent:#4a90e2;
  --danger:#e17055;
  --success:#55efc4;
}

/* ====== Page Wrapper ====== */
.shell{padding:24px;}

/* ====== Page Header ====== */
.page-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;}
.page-header .title{font-size:22px;font-weight:700;color:var(--text);}
.page-header .breadcrumbs{font-size:13px;color:var(--muted);margin-bottom:6px;}
.page-header .breadcrumbs a{color:var(--accent);text-decoration:none;}
.page-header .actions{display:flex;gap:10px;}

/* ====== Panel ====== */
.panel{background:var(--panel);border:1px solid var(--border);border-radius:10px;box-shadow:var(--shadow-1);margin-bottom:22px;}
.panel-header{padding:14px 20px;font-weight:700;border-bottom:1px solid var(--border);color:var(--text);}
.panel-body{padding:20px;}

/* ====== Buttons ====== */
.btn{padding:8px 16px;border-radius:8px;font-weight:600;cursor:pointer;font-size:14px;transition:.2s;text-decoration:none;display:inline-block;border:none;}
.btn-primary{background:var(--accent);color:#fff;}
.btn-primary:hover{background:#0d63d6;color:#fff;}
.btn-ghost{background:transparent;border:1px solid var(--border);color:var(--text);}
.btn-ghost:hover{background:var(--border);color:var(--text);}
.btn-danger{background:var(--danger);color:#fff;}
.btn-danger:hover{background:#c2362e;color:#fff;}
.btn-tool{background:var(--border);border:none;color:var(--text);}

/* ====== Filter Form ====== */
.panel-body form label{display:block;margin-bottom:6px;font-weight:600;color:var(--muted);font-size:12px;}
.panel-body form input,
.panel-body form select{width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;background:var(--panel);color:var(--text);box-shadow:var(--shadow-1);}

/* ====== Table ====== */
.table-wrap{overflow-x:auto;}
table.data{width:100%;border-collapse:collapse;}
table.data th, table.data td{padding:12px 16px;text-align:left;border-bottom:1px solid var(--border);}
table.data thead{background:var(--panel);}
table.data th{font-size:13px;font-weight:700;color:var(--muted);}
table.data tbody tr:hover{background:rgba(0,0,0,0.03);}

/* Identity (avatar + name) */
.identity{display:flex;align-items:center;gap:12px;}
.avatar{width:42px;height:42px;border-radius:12px;overflow:hidden;border:1px solid var(--border);background:var(--panel);
        display:flex;align-items:center;justify-content:center;font-weight:800;color:var(--accent);box-shadow:var(--shadow-1);}
.avatar img{width:100%;height:100%;object-fit:cover;border-radius:12px;}

/* Rating */
.rating{font-weight:700;color:var(--accent);}
.star{color:var(--accent);}

/* Chips (status tags) */
.chip{display:inline-flex;align-items:center;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;}
.chip .chip-dot{width:8px;height:8px;border-radius:50%;margin-right:6px;}
.chip-active{background:rgba(0,184,148,0.1);color:var(--success);}
.chip-active .chip-dot{background:var(--success);}
.chip-inactive{background:rgba(214,48,49,0.1);color:var(--danger);}
.chip-inactive .chip-dot{background:var(--danger);}

/* ====== Enhanced Pagination ====== */
.pagination-wrapper{
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:16px;
    margin-top:24px;
}

.pagination-info{
    color:var(--muted);
    font-size:14px;
    font-weight:600;
}

.pagination{
    display:flex;
    gap:4px;
    list-style:none;
    padding:0;
    margin:0;
    align-items:center;
}

.pagination li{
    margin:0;
}

.pagination li a,
.pagination li span{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:8px 12px;
    min-width:40px;
    height:40px;
    border-radius:8px;
    border:1px solid var(--border);
    color:var(--text);
    text-decoration:none;
    font-size:14px;
    font-weight:600;
    transition:all 0.2s ease;
    background:var(--panel);
}

.pagination li.active span{
    background:var(--accent);
    color:#fff;
    border-color:var(--accent);
    box-shadow:0 2px 4px rgba(26, 115, 232, 0.3);
}

.pagination li a:hover{
    background:var(--accent);
    color:#fff;
    border-color:var(--accent);
    transform:translateY(-1px);
    box-shadow:0 2px 8px rgba(0, 0, 0, 0.15);
}

.pagination li.disabled span{
    color:var(--muted);
    cursor:not-allowed;
    opacity:0.5;
}

.pagination li.disabled span:hover{
    background:var(--panel);
    transform:none;
    box-shadow:none;
}

/* Page navigation arrows */
.pagination li:first-child a,
.pagination li:first-child span{
    padding-left:16px;
    padding-right:16px;
}

.pagination li:last-child a,
.pagination li:last-child span{
    padding-left:16px;
    padding-right:16px;
}

/* Alert styles */
.alert{
    padding:12px 20px;
    border-radius:8px;
    margin-bottom:20px;
    font-weight:600;
}

.alert-success{
    background:rgba(0,184,148,0.1);
    color:var(--success);
    border:1px solid rgba(0,184,148,0.2);
}
</style>

<div class="shell">
    <div class="page-header">
        <div>
            <div class="breadcrumbs">
                <a href="{{ route('admin.places.index') }}">Places</a> / <span>Manage</span>
            </div>
            <h1 class="title">Places Management</h1>
        </div>
        <div class="actions">
            <button type="button" id="themeToggle" class="btn btn-tool">🌙 Theme</button>
            <a href="{{ route('admin.places.create') }}" class="btn btn-primary">+ Add New Place</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filter Panel -->
    <div class="panel">
        <div class="panel-header">🔍 Filter Places</div>
        <div class="panel-body">
            <form method="GET" action="{{ route('admin.places.index') }}" id="filterForm">
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:16px;">
                    <!-- Search -->
                    <div>
                        <label>Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or location...">
                    </div>
                    <!-- Province -->
                    <div>
                        <label>Province</label>
                        <select name="province" id="provinceSelect">
                            <option value="">All Provinces</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province }}" {{ request('province') == $province ? 'selected' : '' }}>
                                    {{ $province }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- District -->
                    <div>
                        <label>District</label>
                        <select name="district" id="districtSelect">
                            <option value="">All Districts</option>
                            @foreach($districts as $district)
                                <option value="{{ $district }}" {{ request('district') == $district ? 'selected' : '' }}>
                                    {{ $district }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Status -->
                    <div>
                        <label>Status</label>
                        <select name="status">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="actions">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('admin.places.index') }}" class="btn btn-ghost">Clear All</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Places Table -->
    <div class="panel">
        <div class="panel-header">
            📍 All Places
            <span style="color:var(--muted);font-weight:normal;">
                ({{ $places->total() }} total{{ $places->hasPages() ? ', showing 12 per page' : '' }})
            </span>
        </div>
        <div class="panel-body">
            <div class="table-wrap">
                <table class="data">
                    <thead>
                        <tr>
                            <th>Place</th>
                            <th>Location</th>
                            <th>Province</th>
                            <th>District</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th style="min-width:240px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($places as $place)
                            <tr>
                                <td>
                                    <div class="identity">
                                        <div class="avatar">
                                            @if($place->image)
                                                <img src="{{ asset('storage/' . $place->image) }}" alt="{{ $place->name }}">
                                            @else
                                                {{ strtoupper(substr($place->name,0,2)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <div style="font-weight:800;">{{ $place->name }}</div>
                                            <div style="font-size:12px;color:var(--muted);">{{ Str::limit($place->description, 40) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $place->location ?: 'N/A' }}</td>
                                <td>{{ $place->province }}</td>
                                <td>{{ $place->district }}</td>
                                <td>
                                    @if($place->rating)
                                        <div class="rating">★ {{ number_format($place->rating,1) }}</div>
                                    @else
                                        <span style="color:var(--muted);">No rating</span>
                                    @endif
                                </td>
                                <td>
                                    @if($place->status == 'active')
                                        <span class="chip chip-active"><span class="chip-dot"></span>Active</span>
                                    @else
                                        <span class="chip chip-inactive"><span class="chip-dot"></span>Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions" style="display:flex;gap:8px;flex-wrap:wrap;">
                                        <a href="{{ route('admin.places.show',$place) }}" class="btn btn-ghost">👁️ View</a>
                                        <a href="{{ route('admin.places.edit',$place) }}" class="btn btn-primary">✏️ Edit</a>
                                        <form action="{{ route('admin.places.destroy',$place) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this place?')">🗑️ Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center;padding:40px;color:var(--muted);font-weight:600;">
                                    <div style="font-size:48px;margin-bottom:16px;">🔍</div>
                                    No places found matching your criteria.
                                    <div style="margin-top:12px;">
                                        <a href="{{ route('admin.places.index') }}" class="btn btn-ghost">Clear Filters</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($places->hasPages())
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Showing {{ $places->firstItem() }} to {{ $places->lastItem() }} of {{ $places->total() }} places
                    </div>
                    <div>
                        {{ $places->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Province auto-submit for dynamic district loading
    document.getElementById('provinceSelect')?.addEventListener('change', function() {
        // Auto-submit form when province changes to update districts
        document.getElementById('filterForm').submit();
    });

    // Theme toggle functionality
    (function(){
        const key = 'ui-theme';
        const root = document.documentElement;
        const btn = document.getElementById('themeToggle');
        const saved = localStorage.getItem(key);

        // Apply saved theme
        if(saved === 'dark'){
            root.setAttribute('data-theme','dark');
            btn.textContent = '☀️ Theme';
        }

        // Theme toggle event
        btn?.addEventListener('click', function(){
            const isDark = root.getAttribute('data-theme') === 'dark';
            root.setAttribute('data-theme', isDark ? 'light' : 'dark');
            localStorage.setItem(key, isDark ? 'light' : 'dark');
            btn.textContent = isDark ? '🌙 Theme' : '☀️ Theme';
        });

        // Auto-detect system theme preference
        if(!saved && window.matchMedia('(prefers-color-scheme: dark)').matches){
            root.setAttribute('data-theme','dark');
            btn.textContent = '☀️ Theme';
        }
    })();

    // Smooth scroll to top after pagination click
    document.addEventListener('DOMContentLoaded', function() {
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function() {
                setTimeout(() => {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 100);
            });
        });
    });

    // Auto-submit search form on Enter key
    document.querySelector('input[name="search"]')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('filterForm').submit();
        }
    });
</script>
@endsection
