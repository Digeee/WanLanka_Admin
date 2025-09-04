<!-- resources/views/admin/layouts/sidebar.blade.php -->

<style>
        :root {
            --primary-color: #2e8b57;
            --primary-light: #3cb371;
            --primary-dark: #1d6e42;
            --accent-color: #f8f9fa;
            --text-dark: #2d3e50;
            --text-light: #6c757d;
            --glass-bg: rgba(255, 255, 255, 0.85);
            --shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
            --border-radius: 16px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 260px;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: var(--shadow);
            border-right: 1px solid rgba(255, 255, 255, 0.5);
            padding: 20px 0;
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
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(46, 139, 87, 0.2);
            margin-bottom: 20px;
        }

        .logo {
            width: 45px;
            height: 45px;
            background: var(--primary-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            margin-right: 10px;
        }

        .logo-text {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .nav-links {
            list-style: none;
            padding: 0 15px;
            flex-grow: 1;
        }

        .nav-links li {
            margin-bottom: 8px;
        }

        .nav-links a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            text-decoration: none;
            color: var(--text-dark);
            border-radius: 12px;
            transition: var(--transition);
        }

        .nav-links a:hover, .nav-links a.active {
            background: var(--primary-light);
            color: white;
        }

        .nav-links i {
            margin-right: 12px;
            font-size: 18px;
        }

        .nav-label {
            font-size: 15px;
            font-weight: 500;
        }

        .logout-area {
            padding: 15px 20px;
            border-top: 1px solid rgba(46, 139, 87, 0.2);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--primary-light);
            border-radius: 12px;
            color: var(--primary-dark);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .logout-btn:hover {
            background: var(--primary-light);
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
            }

            .logo-text, .nav-label {
                display: none;
            }

            .logo-container {
                justify-content: center;
            }

            .nav-links {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .nav-links a {
                padding: 15px;
                justify-content: center;
            }

            .nav-links i {
                margin-right: 0;
                font-size: 20px;
            }

            .logout-btn {
                justify-content: center;
            }

            .logout-text {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                flex-direction: row;
                padding: 10px;
                align-items: center;
                height: auto;
                position: relative;
            }

            .logo-container {
                padding: 0;
                border-bottom: none;
                margin-bottom: 0;
                margin-right: 15px;
            }

            .nav-links {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
                padding: 0;
                flex-grow: 0;
            }

            .nav-links li {
                margin-bottom: 0;
                margin-right: 5px;
            }

            .logout-area {
                padding: 0;
                border-top: none;
                margin-left: auto;
            }

            .logout-btn {
                width: auto;
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
                <a href="#">
                    <i class="fas fa-suitcase"></i>
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
                <a href="#">
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
                           class="{{ request()->routeIs('admin.accommodations.*') ? 'active' : '' }} nav-link">
                            <i class="fas fa-hotel"></i>
                            <span class="nav-label">Manage Accommodations</span>
                        </a>
                    </li>
            <li>
                <a href="#">
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
