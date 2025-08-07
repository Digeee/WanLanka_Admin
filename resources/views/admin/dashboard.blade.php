<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WanLanka Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100%;
        }

        .logo-img {
            width: 100%;
            max-width: 150px;
            margin-bottom: 20px;
        }

        .nav {
            list-style: none;
            padding: 0;
        }

        .nav li {
            margin-bottom: 10px;
        }

        .nav a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 10px;
            display: block;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav a:hover {
            background-color: #34495e;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .logout {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout:hover {
            background-color: #c82333;
        }

        .widgets {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .widget {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .widget h3 {
            margin: 0;
            font-size: 18px;
            color: #2c3e50;
        }

        .widget p {
            margin: 10px 0 0;
            font-size: 24px;
            font-weight: bold;
            color: #3498db;
        }

        .chart-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .booking-list, .user-management {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .add-user-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .add-user-btn:hover {
            background-color: #218838;
        }

        .approve {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .approve:hover {
            background-color: #218838;
        }

        .reject {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .reject:hover {
            background-color: #c82333;
        }

        .view-user {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .view-user:hover {
            background-color: #2980b9;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 400px;
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .modal-content input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .modal-content button[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-content button[type="submit"]:hover {
            background-color: #218838;
        }

        #closeModal {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 5px;
            cursor: pointer;
        }

        #closeModal:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <img src="logo.png" alt="WanLanka Logo" class="logo-img">
            </div>
            <ul class="nav">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Users</a></li>
                <li><a href="#">Bookings</a></li>
                <li><a href="#">Packages</a></li>
                <li><a href="#">Vehicles</a></li>
                <li><a href="#">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="user-info">
                    <span>Welcome, Admin</span>
                </div>
                <div class="settings">
                    <button class="logout btn btn-danger">Logout</button>
                </div>
            </div>

            <!-- Dashboard Widgets -->
            <div class="widgets">
                <div class="widget">
                    <h3>Users</h3>
                    <p>450</p>
                </div>
                <div class="widget">
                    <h3>Bookings</h3>
                    <p>200</p>
                </div>
                <div class="widget">
                    <h3>Total Revenue</h3>
                    <p>$120,000</p>
                </div>
            </div>

            <!-- Chart Example -->
            <div class="chart-container">
                <canvas id="userGrowthChart"></canvas>
            </div>

            <!-- Latest Bookings -->
            <div class="booking-list">
                <h2>Latest Bookings</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>User</th>
                            <th>Package</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#101</td>
                            <td>John Doe</td>
                            <td>Beach Getaway</td>
                            <td>Pending</td>
                            <td><button class="approve btn btn-success btn-sm">Approve</button></td>
                        </tr>
                        <tr>
                            <td>#102</td>
                            <td>Jane Smith</td>
                            <td>Mountain Trek</td>
                            <td>Approved</td>
                            <td><button class="reject btn btn-danger btn-sm">Reject</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- User Management -->
            <div class="user-management">
                <h2>User Management</h2>
                <button class="add-user-btn btn btn-success">Add New User</button>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>U001</td>
                            <td>Michael Ray</td>
                            <td>michael@ray.com</td>
                            <td>+9412345678</td>
                            <td><button class="view-user btn btn-primary btn-sm">View</button></td>
                        </tr>
                        <tr>
                            <td>U002</td>
                            <td>Linda Page</td>
                            <td>linda@page.com</td>
                            <td>+9412345679</td>
                            <td><button class="view-user btn btn-primary btn-sm">View</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal" id="addUserModal">
        <div class="modal-content">
            <h2>Add New User</h2>
            <form>
                <div class="mb-3">
                    <label for="userName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="userName" name="userName" required>
                </div>
                <div class="mb-3">
                    <label for="userEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="userEmail" name="userEmail" required>
                </div>
                <div class="mb-3">
                    <label for="userPhone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="userPhone" name="userPhone" required>
                </div>
                <button type="submit" class="btn btn-success">Save</button>
                <button type="button" id="closeModal" class="btn btn-danger">Cancel</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
