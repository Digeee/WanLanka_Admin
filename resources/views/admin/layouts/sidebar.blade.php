<!-- resources/views/admin/layouts/sidebar.blade.php -->

<style>
:root {
    --primary-color: #2e8b57;
    --primary-light: #3cb371;
    --primary-dark: #1d6e42;
    --accent-color: #f8f9fa;
    --text-dark: #2d3e50;
    --text-light: #6c757d;
    --glass-bg: rgba(255, 255, 255, 0.75);
    --glass-border: rgba(255, 255, 255, 0.18);
    --shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
    --inner-shadow: inset 0 2px 5px rgba(255, 255, 255, 0.4);
    --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    --border-radius: 16px;
    --font-primary: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 0;
    min-height: 100vh;
    display: flex;
    font-family: var(--font-primary);
}

.sidebar {
    width: 280px;
    background: var(--glass-bg);
    backdrop-filter: blur(16px) saturate(180%);
    -webkit-backdrop-filter: blur(16px) saturate(180%);
    box-shadow: var(--shadow), var(--inner-shadow);
    border-right: 1px solid var(--glass-border);
    padding: 24px 0;
    display: flex;
    flex-direction: column;
    transition: var(--transition);
    z-index: 100;
    height: 100vh;
    position: sticky;
    top: 0;
}

.logo-container {
    display: flex;
    align-items: center;
    padding: 0 24px 24px;
    border-bottom: 1px solid rgba(46, 139, 87, 0.15);
    margin-bottom: 24px;
}

.logo {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 22px;
    margin-right: 12px;
    box-shadow: 0 4px 12px rgba(46, 139, 87, 0.3);
    transition: var(--transition);
}

.logo:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(46, 139, 87, 0.4);
}

.logo-text {
    font-size: 24px;
    font-weight: 700;
    color: var(--primary-dark);
    letter-spacing: 0.5px;
}

.nav-links {
    list-style: none;
    padding: 0 16px;
    flex-grow: 1;
}

.nav-links li {
    margin-bottom: 8px;
    position: relative;
}

.nav-links a {
    display: flex;
    align-items: center;
    padding: 14px 18px;
    text-decoration: none;
    color: var(--text-dark);
    border-radius: 12px;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.nav-links a::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: left 0.7s ease;
}

.nav-links a:hover::before {
    left: 100%;
}

.nav-links a:hover, .nav-links a.active {
    background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
    color: white;
    box-shadow: 0 4px 15px rgba(46, 139, 87, 0.3);
    transform: translateX(4px);
}

.nav-links i {
    margin-right: 14px;
    font-size: 20px;
    width: 24px;
    text-align: center;
    transition: var(--transition);
}

.nav-links a:hover i, .nav-links a.active i {
    transform: scale(1.1);
}

.nav-label {
    font-size: 15px;
    font-weight: 500;
    letter-spacing: 0.3px;
}

/* Dropdown styles */
.dropdown-toggle {
    cursor: pointer;
}

.dropdown-toggle::after {
    content: "▼";
    font-size: 10px;
    margin-left: auto;
    transition: transform 0.3s ease;
}

.dropdown-toggle.collapsed::after {
    transform: rotate(-90deg);
}

.dropdown-menu {
    list-style: none;
    padding: 0;
    margin: 8px 0 0 0;
    background: rgba(46, 139, 87, 0.05);
    border-radius: 8px;
    overflow: hidden;
    display: none;
}

.dropdown-menu.show {
    display: block;
}

.dropdown-menu li {
    margin: 0;
}

.dropdown-menu a {
    padding: 12px 18px 12px 50px;
    font-size: 14px;
    color: var(--text-dark);
    border-radius: 0;
    background: transparent;
    box-shadow: none;
    transform: none;
}

.dropdown-menu a:hover, .dropdown-menu a.active {
    background: rgba(46, 139, 87, 0.15);
    color: var(--primary-dark);
    transform: translateX(2px);
    box-shadow: none;
}

.dropdown-menu a::before {
    display: none;
}

.logout-area {
    padding: 20px 24px;
    border-top: 1px solid rgba(46, 139, 87, 0.15);
}

.logout-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 14px;
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid var(--primary-light);
    border-radius: 12px;
    color: var(--primary-dark);
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 2px 8px rgba(46, 139, 87, 0.1);
}

.logout-btn:hover {
    background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
    color: white;
    box-shadow: 0 4px 15px rgba(46, 139, 87, 0.3);
    transform: translateY(-2px);
}

.logout-btn:active {
    transform: translateY(0);
}

/* Responsive Design */
@media (max-width: 992px) {
    .sidebar {
        width: 80px;
    }

    .logo-text, .nav-label, .dropdown-toggle::after {
        display: none;
    }

    .logo-container {
        justify-content: center;
        padding: 0 16px 20px;
    }

    .logo {
        margin-right: 0;
    }

    .nav-links {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0 10px;
    }

    .nav-links a {
        padding: 16px;
        justify-content: center;
    }

    .nav-links i {
        margin-right: 0;
        font-size: 22px;
    }

    .logout-btn {
        justify-content: center;
        padding: 16px;
    }

    .logout-text {
        display: none;
    }

    .dropdown-menu {
        position: absolute;
        left: 80px;
        top: 0;
        width: 200px;
        box-shadow: var(--shadow);
        z-index: 1000;
    }
}

@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        flex-direction: row;
        padding: 16px;
        align-items: center;
        height: auto;
        position: relative;
        backdrop-filter: blur(12px) saturate(180%);
        -webkit-backdrop-filter: blur(12px) saturate(180%);
    }

    .logo-container {
        padding: 0;
        border-bottom: none;
        margin-bottom: 0;
        margin-right: 16px;
    }

    .nav-links {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
        padding: 0;
        flex-grow: 0;
        margin: 0 8px;
    }

    .nav-links li {
        margin-bottom: 0;
        margin-right: 4px;
    }

    .nav-links a {
        padding: 12px 14px;
    }

    .logout-area {
        padding: 0;
        border-top: none;
        margin-left: auto;
    }

    .logout-btn {
        width: auto;
        padding: 12px 14px;
    }
}
</style>

<nav class="sidebar">
    <div class="logo-container">
        <div class="logo">
            <i class="fas fa-leaf"></i>
        </div>
        <div class="logo-text">WanLanka</div>
    </div>

    <ul class="nav-links">
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }} nav-link">
                <i class="fas fa-tachometer-alt"></i>
                <span class="nav-label">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.packages.index') }}"
               class="{{ request()->routeIs('admin.packages.*') ? 'active' : '' }} nav-link">
                <i class="fas fa-box-open"></i>
                <span class="nav-label">Manage Packages</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.places.index') }}"
               class="{{ request()->routeIs('admin.places.*') ? 'active' : '' }} nav-link">
                <i class="fas fa-map-marker-alt"></i>
                <span class="nav-label">Manage Places</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users.index') }}"
               class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span class="nav-label">Manage Users</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.guiders.index') }}"
            class="{{ request()->routeIs('admin.guiders.*') ? 'active' : '' }}">
                <i class="fas fa-user-check"></i>
                <span class="nav-label">Manage Guiders</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.vehicles.index') }}"
            class="{{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}">
                <i class="fas fa-car"></i>
                <span class="nav-label">Manage Vehicles</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.accommodations.index') }}"
            class="{{ request()->routeIs('admin.accommodations.*') ? 'active' : '' }}">
                <i class="fas fa-hotel"></i>
                <span class="nav-label">Accommodations</span>
            </a>
        </li>
        <li>
            <a href="#bookingsSubmenu" class="dropdown-toggle {{ request()->routeIs('admin.bookings.*') ? '' : 'collapsed' }}" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('admin.bookings.*') ? 'true' : 'false' }}">
                <i class="fas fa-calendar-check"></i>
                <span class="nav-label">Bookings</span>
            </a>
            <ul class="dropdown-menu collapse {{ request()->routeIs('admin.bookings.*') ? 'show' : '' }}" id="bookingsSubmenu">
                <li><a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.index') ? 'active' : '' }}">Individual Place</a></li>
                <li><a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.index') && request()->query('type') == 'package' ? 'active' : '' }}">Fixed Package Booking</a></li>
                <li><a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.index') && request()->query('type') == 'custom' ? 'active' : '' }}">Custom Package Booking</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ route('admin.places.user-sent.index') }}"
               class="{{ request()->routeIs('admin.places.user-sent.*') ? 'active' : '' }}">
                <i class="fas fa-map-marker-alt"></i>
                <span class="nav-label">User Sent Places</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.ui_management.UI_index') }}"
                       class="{{ request()->routeIs('admin.ui_management.*') ? 'active' : '' }} nav-link">
                <i class="fas fa-cog"></i>
                <span class="nav-label">UI Settings</span>
            </a>
        </li>
    </ul>

    <div class="logout-area">
        <button class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span class="logout-text">Logout</span>
        </button>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Add click event to close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const bookingsMenu = document.getElementById('bookingsSubmenu');
        const bookingsToggle = document.querySelector('[href="#bookingsSubmenu"]');

        if (bookingsMenu && bookingsToggle &&
            !bookingsMenu.contains(event.target) &&
            !bookingsToggle.contains(event.target)) {
            const bsCollapse = new bootstrap.Collapse(bookingsMenu, {
                toggle: false
            });

            if (bookingsMenu.classList.contains('show')) {
                bsCollapse.hide();
                bookingsToggle.classList.add('collapsed');
            }
        }
    });
</script>
