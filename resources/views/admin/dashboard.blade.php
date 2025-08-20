<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WANLANKA Admin</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --dark-color: #2b2d42;
            --light-color: #f8f9fa;
            --success-color: #4caf50;
            --warning-color: #ff9800;
            --danger-color: #f44336;
            --sidebar-width: 260px;
            --topbar-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f7fb;
            color: #333;
            margin-left: var(--sidebar-width);
        }

        /* Top Navigation Bar */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
            z-index: 1000;
        }

        .topbar-left {
            display: flex;
            align-items: center;
        }

        .topbar-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark-color);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-icon {
            position: relative;
            color: #6c757d;
            cursor: pointer;
            transition: all 0.3s;
        }

        .notification-icon:hover {
            color: var(--primary-color);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger-color);
            color: white;
            font-size: 10px;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .profile-pic {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        .profile-name {
            font-weight: 500;
            color: var(--dark-color);
        }

        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: var(--success-color);
            margin-left: 5px;
        }

        /* Sidebar Navigation */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px 0;
            z-index: 1001;
            transition: all 0.3s;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 700;
        }

        .sidebar-menu {
            padding: 20px 0;
            overflow-y: auto;
            height: calc(100vh - 120px);
        }

        .menu-title {
            padding: 10px 25px;
            font-size: 12px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            position: relative;
        }

        .menu-item:hover, .menu-item.active {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .menu-item.active:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: white;
        }

        .menu-icon {
            font-size: 18px;
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        .menu-text {
            font-size: 15px;
            font-weight: 500;
        }

        .menu-badge {
            margin-left: auto;
            background-color: var(--accent-color);
            color: var(--dark-color);
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 10px;
        }

        .submenu {
            padding-left: 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .submenu.show {
            max-height: 500px;
        }

        .submenu-item {
            padding: 10px 25px 10px 55px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: block;
            font-size: 14px;
            transition: all 0.3s;
        }

        .submenu-item:hover, .submenu-item.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .menu-item.has-submenu::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            margin-left: auto;
            font-size: 12px;
            transition: transform 0.3s;
        }

        .menu-item.has-submenu.open::after {
            transform: rotate(180deg);
        }

        /* Main Content */
        .main-content {
            margin-top: var(--topbar-height);
            padding: 25px;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 25px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark-color);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                left: -var(--sidebar-width);
            }
            body {
                margin-left: 0;
            }
            .topbar {
                left: 0;
            }
            .sidebar.show {
                left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="https://via.placeholder.com/40" alt="Logo" class="logo">
            <span class="brand-name">TourismPro</span>
        </div>

        <div class="sidebar-menu">
            <div class="menu-title">Main</div>
            <a href="#" class="menu-item active">
                <i class="fas fa-tachometer-alt menu-icon"></i>
                <span class="menu-text">Dashboard</span>
            </a>

            <div class="menu-title">Management</div>
            <div class="menu-item has-submenu">
                <i class="fas fa-users menu-icon"></i>
                <span class="menu-text">User Management</span>
                <span class="menu-badge">3 New</span>
            </div>
            <div class="submenu">
                <a href="#" class="submenu-item">All Users</a>
                <a href="#" class="submenu-item">Add New User</a>
                <a href="#" class="submenu-item">User Roles</a>
            </div>

            <div class="menu-item has-submenu open">
                <i class="fas fa-suitcase menu-icon"></i>
                <span class="menu-text">Package Management</span>
            </div>
            <div class="submenu show">
                <a href="#" class="submenu-item active">All Packages</a>
                <a href="#" class="submenu-item">Create Package</a>
                <a href="#" class="submenu-item">Categories</a>
                <a href="#" class="submenu-item">Bookings</a>
            </div>

            <div class="menu-item has-submenu">
                <i class="fas fa-map-marked-alt menu-icon"></i>
                <span class="menu-text">Guider Management</span>
            </div>
            <div class="submenu">
                <a href="#" class="submenu-item">All Guidres</a>
                <a href="#" class="submenu-item">Add New Guider</a>
                <a href="#" class="submenu-item">Guider Schedule</a>
            </div>

            <div class="menu-item">
                <i class="fas fa-chart-line menu-icon"></i>
                <span class="menu-text">Analytics</span>
            </div>

            <div class="menu-title">System</div>
            <div class="menu-item has-submenu">
                <i class="fas fa-paint-brush menu-icon"></i>
                <span class="menu-text">UI Management</span>
            </div>
            <div class="submenu">
                <a href="#" class="submenu-item">Themes</a>
                <a href="#" class="submenu-item">Menus</a>
                <a href="#" class="submenu-item">Widgets</a>
                <a href="#" class="submenu-item">Custom CSS</a>
            </div>

            <div class="menu-item">
                <i class="fas fa-cog menu-icon"></i>
                <span class="menu-text">Settings</span>
            </div>
        </div>
    </div>

    <!-- Top Navigation Bar -->
    <div class="topbar">
        <div class="topbar-left">
            <span class="topbar-title">Dashboard Overview</span>
        </div>
        <div class="topbar-right">
            <div class="notification-icon">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">5</span>
            </div>
            <div class="notification-icon">
                <i class="fas fa-envelope"></i>
                <span class="notification-badge">3</span>
            </div>
            <div class="user-profile">
                <img src="https://via.placeholder.com/36" alt="Profile" class="profile-pic">
                <span class="profile-name">Admin</span>
                <span class="status-indicator"></span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Welcome to Tourism Management System</h2>
            </div>
            <p>This is your admin dashboard where you can manage users, tour packages, guiders, and other system settings.</p>
        </div>
    </div>

    <script>
        // Toggle submenus
        document.querySelectorAll('.menu-item.has-submenu').forEach(item => {
            item.addEventListener('click', function(e) {
                // Don't toggle if clicking on a link inside
                if (e.target.tagName === 'A') return;

                // Close all other submenus first
                document.querySelectorAll('.menu-item.has-submenu').forEach(otherItem => {
                    if (otherItem !== this) {
                        otherItem.classList.remove('open');
                        otherItem.nextElementSibling.classList.remove('show');
                    }
                });

                // Toggle this submenu
                this.classList.toggle('open');
                const submenu = this.nextElementSibling;
                submenu.classList.toggle('show');
            });
        });

        // For mobile view (you can add a hamburger menu button)
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
        }
    </script>
</body>
</html>
