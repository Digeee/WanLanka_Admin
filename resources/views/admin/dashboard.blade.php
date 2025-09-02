<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WanLanka - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            background: linear-gradient(120deg, #f0f7da 0%, #e0f0e0 100%);
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Navigation */
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

        /* Main Content Area */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .user-info {
            display: flex;
            align-items: center;
            background: var(--glass-bg);
            padding: 10px 15px;
            border-radius: 50px;
            box-shadow: var(--shadow);
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
            border: 2px solid var(--primary-light);
        }

        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(31, 38, 135, 0.2);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .card-title {
            font-size: 16px;
            color: var(--text-light);
            font-weight: 500;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(46, 139, 87, 0.15);
            color: var(--primary-color);
            font-size: 20px;
        }

        .card-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 5px;
        }

        .card-footer {
            font-size: 14px;
            color: var(--text-light);
            border-top: 1px solid rgba(46, 139, 87, 0.1);
            padding-top: 10px;
            margin-top: 15px;
        }

        /* Content Sections */
        .content-section {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.5);
            margin-bottom: 30px;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        /* Table Styles */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid rgba(46, 139, 87, 0.1);
        }

        .data-table th {
            background: rgba(46, 139, 87, 0.1);
            color: var(--primary-dark);
            font-weight: 600;
        }

        .data-table tr:hover {
            background: rgba(46, 139, 87, 0.05);
        }

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-active {
            background: rgba(46, 139, 87, 0.15);
            color: var(--primary-dark);
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.15);
            color: #c8a415;
        }

        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            background: var(--primary-light);
            color: white;
            cursor: pointer;
            margin-right: 5px;
            transition: var(--transition);
        }

        .action-btn:hover {
            background: var(--primary-dark);
        }

        .action-btn.delete {
            background: #dc3545;
        }

        .action-btn.delete:hover {
            background: #bd2130;
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
            .admin-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                flex-direction: row;
                padding: 10px;
                align-items: center;
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

            .main-content {
                padding: 20px;
            }

            .dashboard-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Vertical Navigation Sidebar -->
        <nav class="sidebar">
            <div class="logo-container">
                <div class="logo">
                    <i class="fas fa-leaf"></i>
                </div>
                <div class="logo-text">WanLanka</div>
            </div>

            <ul class="nav-links">
                <li>
                    <a href="#" class="active">
                        <i class="fas fa-home"></i>
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
                    <a href="#">
                        <i class="fas fa-users"></i>
                        <span class="nav-label">Manage Users</span>
                    </a>
                </li>

                <li>
                        <a href="{{ route('admin.guiders.index') }}">
                            <i class="fas fa-user-check"></i>
                            <span class="nav-label">Manage Guiders</span>
                        </a>

                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-car"></i>
                        <span class="nav-label">Manage Vehicles</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-hotel"></i>
                        <span class="nav-label">Accommodations</span>
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

        <!-- Main Content Area -->
        <main class="main-content">
            <div class="header">
                <h1 class="page-title">Admin Dashboard</h1>
                <div class="user-info">
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=2e8b57&color=fff" alt="Admin User">
                    <span>Admin User</span>
                </div>
            </div>

            <!-- Dashboard Stats -->
            <div class="dashboard-cards">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Total Users</div>
                        <div class="card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="card-value">1,248</div>
                    <div class="card-footer">+12% from last month</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Bookings</div>
                        <div class="card-icon">
                            <i class="fas fa-suitcase"></i>
                        </div>
                    </div>
                    <div class="card-value">356</div>
                    <div class="card-footer">+8% from last month</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Revenue</div>
                        <div class="card-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                    <div class="card-value">$24,582</div>
                    <div class="card-footer">+15% from last month</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Pending Requests</div>
                        <div class="card-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="card-value">28</div>
                    <div class="card-footer">-5% from last month</div>
                </div>
            </div>

            <!-- Recent Bookings Section -->
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">Recent Bookings</h2>
                    <button class="btn btn-primary">View All</button>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Customer</th>
                            <th>Package</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#WL1258</td>
                            <td>John Smith</td>
                            <td>7 Days Cultural Tour</td>
                            <td>15 Oct 2023</td>
                            <td>$1,250</td>
                            <td><span class="status status-active">Confirmed</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-eye"></i></button>
                                <button class="action-btn"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#WL1257</td>
                            <td>Emma Johnson</td>
                            <td>5 Days Beach Vacation</td>
                            <td>14 Oct 2023</td>
                            <td>$980</td>
                            <td><span class="status status-pending">Pending</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-eye"></i></button>
                                <button class="action-btn"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#WL1256</td>
                            <td>Robert Brown</td>
                            <td>10 Days Adventure Tour</td>
                            <td>13 Oct 2023</td>
                            <td>$1,850</td>
                            <td><span class="status status-active">Confirmed</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-eye"></i></button>
                                <button class="action-btn"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#WL1255</td>
                            <td>Sarah Williams</td>
                            <td>3 Days City Tour</td>
                            <td>12 Oct 2023</td>
                            <td>$450</td>
                            <td><span class="status status-active">Confirmed</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-eye"></i></button>
                                <button class="action-btn"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Recent Users Section -->
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">Recently Registered Users</h2>
                    <button class="btn btn-primary">View All</button>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#USR258</td>
                            <td>Michael Clark</td>
                            <td>michael@example.com</td>
                            <td>14 Oct 2023</td>
                            <td><span class="status status-active">Active</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-eye"></i></button>
                                <button class="action-btn"><i class="fas fa-edit"></i></button>
                                <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#USR257</td>
                            <td>Jennifer Adams</td>
                            <td>jennifer@example.com</td>
                            <td>13 Oct 2023</td>
                            <td><span class="status status-active">Active</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-eye"></i></button>
                                <button class="action-btn"><i class="fas fa-edit"></i></button>
                                <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#USR256</td>
                            <td>David Wilson</td>
                            <td>david@example.com</td>
                            <td>12 Oct 2023</td>
                            <td><span class="status status-pending">Inactive</span></td>
                            <td>
                                <button class="action-btn"><i class="fas fa-eye"></i></button>
                                <button class="action-btn"><i class="fas fa-edit"></i></button>
                                <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        // Simple JavaScript for interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Navigation active state
            const navLinks = document.querySelectorAll('.nav-links a');

            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Card hover effect enhancement
            const cards = document.querySelectorAll('.card');

            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>
