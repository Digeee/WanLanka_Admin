@extends('admin.layouts.master')

@section('content')
<style>
    /* ====== Design Tokens (Light / Dark) ====== */
    :root{
        --bg:#f8fafc; --panel:#ffffff; --muted:#64748b; --text:#0f172a;
        --border:#e2e8f0; --ring:#cbd5e1; --accent:#3b82f6; --accent-2:#22c55e;
        --danger:#ef4444; --warning:#f59e0b; --purple:#8b5cf6; --pink:#ec4899;
        --radius:16px;
        --shadow-1:0 10px 20px rgba(2,6,23,.06);
        --shadow-2:0 18px 40px rgba(2,6,23,.12);
        --glass: blur(10px) saturate(1.05);
    }
    [data-theme="dark"]{
        --bg:#0b1220; --panel:#0f172a; --muted:#94a3b8; --text:#e5e7eb;
        --border:#1f2937; --ring:#334155; --accent:#60a5fa; --accent-2:#34d399;
        --danger:#f87171; --warning:#fbbf24; --purple:#a78bfa; --pink:#f472b6;
        --shadow-1:0 10px 22px rgba(0,0,0,.35);
        --shadow-2:0 22px 50px rgba(0,0,0,.45);
    }

    /* ====== Page Shell ====== */
    .shell{ max-width:1400px; margin:28px auto 80px; padding:0 20px; color:var(--text); }
    body{
        background:
           radial-gradient(1200px 600px at 10% -10%, color-mix(in oklab, var(--accent), transparent 94%), transparent),
           var(--bg);
    }

    /* ====== Header ====== */
    .page-header{
        display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:18px;
        background: linear-gradient(180deg, color-mix(in oklab, var(--panel), transparent 4%), transparent);
        border:1px solid var(--border); border-radius:18px; padding:14px 18px; box-shadow: var(--shadow-1);
        overflow:hidden;
    }
    [data-theme="dark"] .page-header{
        background:
          radial-gradient(1200px 150px at 10% -40%, rgba(59,130,246,.12), transparent 70%),
          linear-gradient(180deg, #0f172a 0%, #0b1220 100%);
        border:1px solid var(--ring);
        box-shadow:0 18px 50px rgba(2,6,23,.55), inset 0 1px 0 rgba(255,255,255,.04);
    }
    .title{ margin:0; font-size:26px; font-weight:800; letter-spacing:.2px; }
    [data-theme="dark"] .title{ color:#f8fafc; text-shadow:0 1px 0 rgba(0,0,0,.45); }
    .breadcrumbs{ font-size:12px; color:var(--muted); }
    .breadcrumbs a{ color:inherit; text-decoration:none; }
    .actions{ display:flex; gap:10px; flex-wrap:wrap; }

    /* ====== Buttons ====== */
    .btn{
        --fg:var(--text); --bd:var(--ring); --fill:color-mix(in oklab,var(--panel),transparent 10%);
        --shine:linear-gradient(115deg,transparent 0%,rgba(255,255,255,.16) 45%,rgba(255,255,255,.28) 55%,transparent 70%);
        position:relative; isolation:isolate; appearance:none; cursor:pointer;
        font-weight:800; letter-spacing:.3px; font-size:14px; border-radius:999px; padding:10px 16px;
        text-decoration:none; display:inline-flex; align-items:center; gap:8px;

        background-image:
          var(--shine),
          linear-gradient(var(--fill),var(--fill)),
          linear-gradient(135deg,var(--bd),color-mix(in oklab,var(--bd),#000 12%));
        background-origin:padding-box,padding-box,border-box;
        background-clip:padding-box,padding-box,border-box;
        background-size:220% 100%,100% 100%,100% 100%;
        background-position:-120% 0,0 0,0 0;

        border:1.5px solid transparent; color:var(--fg);
        box-shadow:var(--shadow-1);
        transition:background-position .6s ease,box-shadow .25s ease,color .25s ease,border-color .25s ease, transform .06s ease;
        overflow:hidden; backface-visibility:hidden; transform:translateZ(0);
    }
    .btn:hover{ background-position:120% 0,0 0,0 0; box-shadow:var(--shadow-2); }
    .btn:active{ transform:translateY(1px); }
    .btn:focus-visible{ outline:none; box-shadow:0 0 0 3px color-mix(in oklab,var(--accent),transparent 60%), var(--shadow-2); }

    .btn-primary{
        --fg:color-mix(in oklab,var(--accent),#000 35%);
        --bd:color-mix(in oklab,var(--accent),#000 15%);
        --fill:color-mix(in oklab,var(--panel),transparent 0%);
    }
    .btn-primary:hover{
        color:#fff; text-shadow:0 1px 0 rgba(0,0,0,.25);
        background-image:
          var(--shine),
          linear-gradient(180deg, color-mix(in oklab,var(--accent),#000 10%), var(--accent)),
          linear-gradient(135deg, color-mix(in oklab,var(--accent),#000 15%), color-mix(in oklab,var(--accent),#000 26%));
        border-color:transparent;
    }
    .btn-neutral{
        --fg: color-mix(in oklab,var(--muted),#000 10%);
        --bd: var(--ring);
        --fill: color-mix(in oklab,var(--panel),transparent 12%);
        backdrop-filter: var(--glass);
    }
    .btn-neutral:hover{ --fill:color-mix(in oklab,var(--panel),transparent 0%); --fg:var(--text); }

    /* ====== Stat Cards ====== */
    .stats{ display:grid; gap:14px; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); margin-bottom:24px; }

    .stat{
        position:relative; border:1px solid var(--border); border-radius:18px; padding:16px; overflow:hidden;
        background:
          radial-gradient(220px 120px at 0% 0%, color-mix(in oklab, var(--accent), transparent 88%), transparent 60%),
          var(--panel);
        box-shadow:var(--shadow-1);
        transition:transform .08s ease, box-shadow .25s ease;
        display:flex; flex-direction:column; justify-content:space-between;
    }
    .stat:hover{ transform: translateY(-2px); box-shadow:var(--shadow-2); }
    .stat h3{ margin:0 0 8px; font-size:13px; letter-spacing:.4px; text-transform:uppercase; color:var(--muted); font-weight:800; }
    .stat p{ margin:0; font-size:32px; font-weight:900; letter-spacing:.2px; color:var(--text); }
    .stat-icon{
        position:absolute; right:16px; top:16px; width:48px; height:48px; border-radius:12px;
        display:flex; align-items:center; justify-content:center; font-size:20px;
        background:color-mix(in oklab, var(--accent), transparent 85%); color:var(--accent);
    }

    .t-blue{ background: radial-gradient(220px 120px at 0% 0%, color-mix(in oklab, var(--accent), transparent 86%), transparent 60%), var(--panel); }
    .t-green{ background: radial-gradient(220px 120px at 0% 0%, color-mix(in oklab, var(--accent-2), transparent 86%), transparent 60%), var(--panel); }
    .t-purple{ background: radial-gradient(220px 120px at 0% 0%, color-mix(in oklab, var(--purple), transparent 86%), transparent 60%), var(--panel); }
    .t-amber{ background: radial-gradient(220px 120px at 0% 0%, color-mix(in oklab, var(--warning), transparent 86%), transparent 60%), var(--panel); }
    .t-pink{ background: radial-gradient(220px 120px at 0% 0%, color-mix(in oklab, var(--pink), transparent 86%), transparent 60%), var(--panel); }
    .t-danger{ background: radial-gradient(220px 120px at 0% 0%, color-mix(in oklab, var(--danger), transparent 86%), transparent 60%), var(--panel); }

    [data-theme="dark"] .stat{
        border-color: var(--ring);
        background:
          radial-gradient(260px 140px at -10% -30%, rgba(96,165,250,.18), transparent 60%),
          linear-gradient(180deg, #0f172a 0%, #0b1220 100%);
        box-shadow:0 12px 38px rgba(0,0,0,.45), inset 0 1px 0 rgba(255,255,255,.03);
    }
    [data-theme="dark"] .t-green{
        background: radial-gradient(260px 140px at -10% -30%, rgba(52,211,153,.18), transparent 60%), linear-gradient(180deg, #0f172a 0%, #0b1220 100%);
    }
    [data-theme="dark"] .t-purple{
        background: radial-gradient(260px 140px at -10% -30%, rgba(167,139,250,.18), transparent 60%), linear-gradient(180deg, #0f172a 0%, #0b1220 100%);
    }
    [data-theme="dark"] .t-amber{
        background: radial-gradient(260px 140px at -10% -30%, rgba(251,191,36,.18), transparent 60%), linear-gradient(180deg, #0f172a 0%, #0b1220 100%);
    }
    [data-theme="dark"] .t-pink{
        background: radial-gradient(260px 140px at -10% -30%, rgba(236,72,153,.18), transparent 60%), linear-gradient(180deg, #0f172a 0%, #0b1220 100%);
    }
    [data-theme="dark"] .t-danger{
        background: radial-gradient(260px 140px at -10% -30%, rgba(239,68,68,.18), transparent 60%), linear-gradient(180deg, #0f172a 0%, #0b1220 100%);
    }

    /* ====== Dashboard Grid ====== */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        margin-top: 24px;
    }
    @media (min-width: 1200px) {
        .dashboard-grid {
            grid-template-columns: 2fr 1fr;
        }
    }

    /* ====== Panels ====== */
    .panel {
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 20px;
        box-shadow: var(--shadow-1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .panel:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-2);
    }
    [data-theme="dark"] .panel {
        border-color: var(--ring);
        background: linear-gradient(180deg, #0f172a 0%, #0b1220 100%);
        box-shadow: 0 12px 38px rgba(0,0,0,.45), inset 0 1px 0 rgba(255,255,255,.03);
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }
    .panel-title {
        font-size: 18px;
        font-weight: 800;
        color: var(--text);
    }

    /* ====== Chart Container ====== */
    .chart-container {
        height: 280px;
        position: relative;
    }

    /* ====== Activity & Notification Items ====== */
    .activity-item, .notification-item {
        padding: 12px 0;
        border-bottom: 1px solid var(--border);
        display: flex;
        gap: 12px;
    }
    [data-theme="dark"] .activity-item,
    [data-theme="dark"] .notification-item {
        border-color: var(--ring);
    }
    .activity-item:last-child,
    .notification-item:last-child {
        border: none;
    }
    .activity-icon, .notification-icon {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .activity-text, .notification-text {
        flex: 1;
    }
    .activity-title, .notification-title {
        font-weight: 700;
        margin: 0 0 4px;
        font-size: 14px;
    }
    .activity-desc, .notification-desc {
        font-size: 13px;
        color: var(--muted);
    }
    .activity-time, .notification-time {
        font-size: 12px;
        color: var(--muted);
        margin-top: 4px;
    }
    .notification-badge {
        background: var(--danger);
        color: white;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 10px;
        font-weight: 800;
    }
    .notification-dismiss {
        background: none;
        border: none;
        color: var(--muted);
        cursor: pointer;
        font-size: 18px;
        margin-left: 8px;
        opacity: 0.7;
        transition: opacity 0.2s;
    }
    .notification-dismiss:hover {
        opacity: 1;
        color: var(--danger);
    }

    /* ====== Quick Actions ====== */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
        margin-bottom: 24px;
    }
    .action-card {
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
        color: var(--text);
    }
    .action-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-2);
        border-color: var(--accent);
    }
    .action-icon {
        font-size: 24px;
        margin-bottom: 8px;
        color: var(--accent);
    }
    .action-title {
        font-size: 14px;
        font-weight: 600;
    }

    /* ====== Mini Charts ====== */
    .mini-chart {
        height: 60px;
        width: 100%;
        margin-top: 8px;
    }

    /* ====== Progress Bars ====== */
    .progress-bar {
        height: 6px;
        background: var(--border);
        border-radius: 3px;
        overflow: hidden;
        margin-top: 8px;
    }
    .progress-fill {
        height: 100%;
        border-radius: 3px;
        transition: width 0.5s ease;
    }

    /* ====== Fade-in Animation ====== */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .fade-in {
        animation: fadeIn 0.5s ease forwards;
    }

    /* ====== Pulse Animation ====== */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    .pulse {
        animation: pulse 2s infinite;
    }

    /* ====== Stats Grid ====== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    /* ====== Resource Distribution ====== */
    .distribution-chart {
        height: 200px;
        position: relative;
    }

    /* ====== Booking Status Cards ====== */
    .booking-status-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 12px;
        margin: 20px 0;
    }
    .booking-status-card {
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 12px;
        text-align: center;
        box-shadow: var(--shadow-1);
    }
    .booking-status-count {
        font-size: 24px;
        font-weight: 700;
        margin: 0 0 4px;
    }
    .booking-status-label {
        font-size: 12px;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<div class="shell" id="dashboard-root">
    <div class="page-header">
        <div>
            <div class="breadcrumbs">Dashboard</div>
            <h1 class="title">Admin Dashboard</h1>
        </div>
        <div class="actions">
            <button class="btn btn-neutral" type="button" id="themeToggle" aria-label="Toggle theme">Theme</button>
            <a href="{{ route('admin.guiders.create') }}" class="btn btn-primary">Add Guider</a>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="{{ route('admin.guiders.index') }}" class="action-card fade-in" style="animation-delay: 0.1s">
            <div class="action-icon">👨‍💼</div>
            <div class="action-title">Manage Guiders</div>
        </a>
        <a href="{{ route('admin.vehicles.index') }}" class="action-card fade-in" style="animation-delay: 0.2s">
            <div class="action-icon">🚗</div>
            <div class="action-title">Manage Vehicles</div>
        </a>
        <a href="{{ route('admin.accommodations.index') }}" class="action-card fade-in" style="animation-delay: 0.3s">
            <div class="action-icon">🏨</div>
            <div class="action-title">Manage Accommodations</div>
        </a>
        <a href="{{ route('admin.places.index') }}" class="action-card fade-in" style="animation-delay: 0.4s">
            <div class="action-icon">🏞️</div>
            <div class="action-title">Manage Places</div>
        </a>
        <a href="{{ route('admin.packages.index') }}" class="action-card fade-in" style="animation-delay: 0.5s">
            <div class="action-icon">📦</div>
            <div class="action-title">Manage Packages</div>
        </a>
        <a href="{{ route('admin.users.index') }}" class="action-card fade-in" style="animation-delay: 0.6s">
            <div class="action-icon">👥</div>
            <div class="action-title">Manage Users</div>
        </a>
        <a href="{{ route('admin.bookings.index') }}" class="action-card fade-in" style="animation-delay: 0.7s">
            <div class="action-icon">📅</div>
            <div class="action-title">Manage Bookings</div>
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="stats">
        <div class="stat t-blue fade-in" style="animation-delay: 0.1s">
            <h3>Total Guiders</h3>
            <p>{{ $guiderCount }}</p>
            <div class="stat-icon">👨‍💼</div>
            <div class="mini-chart">
                <canvas id="guiderChart"></canvas>
            </div>
        </div>
        <div class="stat t-purple fade-in" style="animation-delay: 0.2s">
            <h3>Total Vehicles</h3>
            <p>{{ $vehicleCount }}</p>
            <div class="stat-icon">🚗</div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 75%; background: var(--purple);"></div>
            </div>
        </div>
        <div class="stat t-green fade-in" style="animation-delay: 0.3s">
            <h3>Total Accommodations</h3>
            <p>{{ $accommodationCount }}</p>
            <div class="stat-icon">🏨</div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 60%; background: var(--accent-2);"></div>
            </div>
        </div>
        <div class="stat t-amber fade-in" style="animation-delay: 0.4s">
            <h3>Total Places</h3>
            <p>{{ $placeCount }}</p>
            <div class="stat-icon">🏞️</div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 85%; background: var(--warning);"></div>
            </div>
        </div>
        <div class="stat t-pink fade-in" style="animation-delay: 0.5s">
            <h3>Total Packages</h3>
            <p>{{ $packageCount }}</p>
            <div class="stat-icon">📦</div>
            <div class="mini-chart">
                <canvas id="packageChart"></canvas>
            </div>
        </div>
        <div class="stat t-blue fade-in" style="animation-delay: 0.6s">
            <h3>Total Users</h3>
            <p>{{ $userCount }}</p>
            <div class="stat-icon">👥</div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 90%; background: var(--accent);"></div>
            </div>
        </div>
        <div class="stat t-danger fade-in" style="animation-delay: 0.7s">
            <h3>Total Bookings</h3>
            <p>{{ $bookingCount }}</p>
            <div class="stat-icon">📅</div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 70%; background: var(--danger);"></div>
            </div>
        </div>
    </div>

    <!-- Booking Status Overview -->
    <div class="panel fade-in" style="animation-delay: 0.8s">
        <div class="panel-header">
            <h2 class="panel-title">Booking Status Overview</h2>
            <a href="{{ route('admin.bookings.index') }}" style="font-size: 12px; color: var(--accent); text-decoration: none;">View All Bookings</a>
        </div>
        <div class="booking-status-cards">
            <div class="booking-status-card">
                <div class="booking-status-count">{{ $todayBookings }}</div>
                <div class="booking-status-label">Today</div>
            </div>
            <div class="booking-status-card">
                <div class="booking-status-count" style="color: var(--warning);">{{ $pendingBookings }}</div>
                <div class="booking-status-label">Pending</div>
            </div>
            <div class="booking-status-card">
                <div class="booking-status-count" style="color: var(--accent-2);">{{ $confirmedBookings }}</div>
                <div class="booking-status-label">Confirmed</div>
            </div>
            <div class="booking-status-card">
                <div class="booking-status-count" style="color: var(--danger);">{{ $cancelledBookings }}</div>
                <div class="booking-status-label">Cancelled</div>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Main Content: Charts + Recent Activity -->
        <div>
            <!-- Charts Row -->
            <div class="stats-grid">
                <!-- Bookings Chart -->
                <div class="panel fade-in" style="animation-delay: 0.9s">
                    <div class="panel-header">
                        <h2 class="panel-title">Bookings Overview</h2>
                    </div>
                    <div class="chart-container">
                        <canvas id="bookingsChart"></canvas>
                    </div>
                </div>

                <!-- Resource Distribution -->
                <div class="panel fade-in" style="animation-delay: 1.0s">
                    <div class="panel-header">
                        <h2 class="panel-title">Resource Distribution</h2>
                    </div>
                    <div class="distribution-chart">
                        <canvas id="distributionChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="panel fade-in" style="animation-delay: 1.1s; margin-top: 20px;">
                <div class="panel-header">
                    <h2 class="panel-title">Recent Activity</h2>
                    <a href="#" style="font-size: 12px; color: var(--accent); text-decoration: none;">View All</a>
                </div>
                <div class="activity-list">
                    @foreach($recentActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon" style="background: color-mix(in oklab, var(--accent), transparent 80%);">
                                @if($activity['type'] === 'guider')
                                    👨‍💼
                                @elseif($activity['type'] === 'user')
                                    👥
                                @elseif($activity['type'] === 'package')
                                    📦
                                @elseif($activity['type'] === 'booking')
                                    📅
                                @else
                                    🔔
                                @endif
                            </div>
                            <div class="activity-text">
                                <h4 class="activity-title">{{ $activity['title'] }}</h4>
                                <p class="activity-desc">{{ $activity['description'] }}</p>
                                <p class="activity-time">{{ $activity['time']->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar: Notifications + Performance -->
        <div>
            <!-- Notifications -->
            <div class="panel fade-in" style="animation-delay: 1.2s">
                <div class="panel-header">
                    <h2 class="panel-title">Notifications</h2>
                    @if($unreadNotificationsCount > 0)
                        <span class="notification-badge pulse">{{ $unreadNotificationsCount }}</span>
                    @endif
                </div>
                <div class="notification-list">
                    @forelse($notifications as $note)
                        <div class="notification-item">
                            <div class="notification-icon" style="background: color-mix(in oklab, {{ $note['type'] === 'booking' ? 'var(--accent-2)' : ($note['type'] === 'user' ? 'var(--purple)' : 'var(--accent)') }}, transparent 80%);">
                                @if($note['type'] === 'booking')
                                    📅
                                @elseif($note['type'] === 'user')
                                    👤
                                @elseif($note['type'] === 'guider')
                                    👨‍💼
                                @elseif($note['type'] === 'package')
                                    📦
                                @else
                                    🔔
                                @endif
                            </div>
                            <div class="notification-text">
                                <h4 class="notification-title">{{ $note['title'] }}</h4>
                                <p class="notification-desc">{{ $note['message'] }}</p>
                                <p class="notification-time">{{ $note['created_at']->diffForHumans() }}</p>
                            </div>
                            <button class="notification-dismiss" title="Dismiss">×</button>
                        </div>
                    @empty
                        <p style="color: var(--muted); font-style: italic; text-align: center; padding: 20px;">No notifications</p>
                    @endforelse
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="panel fade-in" style="animation-delay: 1.3s; margin-top: 20px;">
                <div class="panel-header">
                    <h2 class="panel-title">Performance</h2>
                </div>
                <div class="performance-metrics">
                    <div class="metric">
                        <div class="metric-header">
                            <span>System Uptime</span>
                            <span>99.8%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 99.8%; background: var(--accent-2);"></div>
                        </div>
                    </div>
                    <div class="metric" style="margin-top: 16px;">
                        <div class="metric-header">
                            <span>Response Time</span>
                            <span>128ms</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 85%; background: var(--accent);"></div>
                        </div>
                    </div>
                    <div class="metric" style="margin-top: 16px;">
                        <div class="metric-header">
                            <span>Storage Usage</span>
                            <span>65%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 65%; background: var(--purple);"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            updateCharts();
        });
        if(!saved && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches){
            root.setAttribute('data-theme','dark');
        }
    })();

    // Helper function to get CSS variable
    function getCssVar(name) {
        return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
    }

    // Update all charts when theme changes
    function updateCharts() {
        setTimeout(() => {
            initBookingsChart();
            initDistributionChart();
            initMiniCharts();
        }, 100);
    }

    // Main Bookings Chart
    function initBookingsChart() {
        const ctx = document.getElementById('bookingsChart').getContext('2d');
        if(window.bookingsChartInstance) window.bookingsChartInstance.destroy();

        window.bookingsChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Bookings',
                    data: [12, 19, 15, 22, 30, 28],
                    borderColor: getCssVar('--accent'),
                    backgroundColor: getCssVar('--accent') + '20',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: getCssVar('--panel'),
                    pointBorderColor: getCssVar('--accent'),
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: getCssVar('--text'),
                            font: { size: 12 }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'transparent' },
                        ticks: { color: getCssVar('--muted') }
                    },
                    y: {
                        grid: { color: getCssVar('--border') },
                        ticks: { color: getCssVar('--muted') }
                    }
                }
            }
        });
    }

    // Resource Distribution Chart
    function initDistributionChart() {
        const ctx = document.getElementById('distributionChart').getContext('2d');
        if(window.distributionChartInstance) window.distributionChartInstance.destroy();

        window.distributionChartInstance = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Guiders', 'Vehicles', 'Accommodations', 'Places', 'Packages', 'Bookings'],
                datasets: [{
                    data: [{{ $guiderCount }}, {{ $vehicleCount }}, {{ $accommodationCount }}, {{ $placeCount }}, {{ $packageCount }}, {{ $bookingCount }}],
                    backgroundColor: [
                        getCssVar('--accent'),
                        getCssVar('--purple'),
                        getCssVar('--accent-2'),
                        getCssVar('--warning'),
                        getCssVar('--pink'),
                        getCssVar('--danger')
                    ],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: getCssVar('--text'),
                            padding: 15,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    }

    // Mini Charts for Stats
    function initMiniCharts() {
        // Guider mini chart
        const guiderCtx = document.getElementById('guiderChart').getContext('2d');
        new Chart(guiderCtx, {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', ''],
                datasets: [{
                    data: [5, 8, 12, 15, 18, {{ $guiderCount }}],
                    borderColor: getCssVar('--accent'),
                    borderWidth: 2,
                    fill: false,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { display: false },
                    y: { display: false }
                },
                plugins: { legend: { display: false } }
            }
        });

        // Package mini chart
        const packageCtx = document.getElementById('packageChart').getContext('2d');
        new Chart(packageCtx, {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', ''],
                datasets: [{
                    data: [3, 7, 10, 14, 18, {{ $packageCount }}],
                    borderColor: getCssVar('--pink'),
                    borderWidth: 2,
                    fill: false,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { display: false },
                    y: { display: false }
                },
                plugins: { legend: { display: false } }
            }
        });
    }

    // Initialize all charts
    document.addEventListener('DOMContentLoaded', function() {
        initBookingsChart();
        initDistributionChart();
        initMiniCharts();

        // Notification Dismiss
        document.querySelectorAll('.notification-dismiss').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.notification-item').style.opacity = '0';
                setTimeout(() => this.closest('.notification-item').remove(), 300);
            });
        });

        // Add hover effects to stats
        document.querySelectorAll('.stat').forEach(stat => {
            stat.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
            });
            stat.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endsection
