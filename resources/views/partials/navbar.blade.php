<!-- Navbar Partial -->
<div class="navbar">
    <div class="navbar-left">
        <!-- Logo and User Info -->
        <img src="your_logo_url_here" alt="Logo" class="logo">
        <span class="navbar-title">Pluto</span>
    </div>

    <!-- Profile & Notifications -->
    <div class="navbar-right">
        <div class="notification-icon">
            <i class="fas fa-bell"></i> <!-- Bell Icon -->
            <span class="notification-badge">2</span>
        </div>
        <div class="notification-icon">
            <i class="fas fa-question-circle"></i> <!-- Help Icon -->
            <span class="notification-badge">3</span>
        </div>
        <div class="profile">
            <img src="user_profile_pic_url" alt="Profile" class="profile-pic">
            <span class="status-indicator"></span> <!-- Online indicator -->
        </div>
    </div>
</div>

<div class="sidebar">
    <div class="menu-item">
        <a href="#">Dashboard</a>
    </div>
    <div class="menu-item">
        <a href="#">Widgets</a>
    </div>
    <div class="menu-item">
        <a href="#">Elements</a>
    </div>
    <!-- Add more menu items as needed -->
</div>

<!-- Internal CSS -->
<style>
    /* Navbar Styles */
    .navbar {
        display: flex;
        justify-content: space-between;
        background-color: #2b3e50;
        color: white;
        padding: 15px;
        align-items: center;
    }

    .navbar-left {
        display: flex;
        align-items: center;
    }

    .logo {
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }

    .navbar-title {
        font-size: 24px;
        font-weight: bold;
    }

    .navbar-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .notification-icon {
        position: relative;
        font-size: 20px;
    }

    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: red;
        color: white;
        font-size: 12px;
        border-radius: 50%;
        padding: 2px 6px;
    }

    .profile {
        position: relative;
    }

    .profile-pic {
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }

    .status-indicator {
        position: absolute;
        bottom: 0;
        right: 0;
        background-color: green;
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    /* Sidebar Styles */
    .sidebar {
        background-color: #34495e;
        color: white;
        padding: 20px;
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .menu-item {
        padding: 10px;
        font-size: 16px;
        font-weight: 600;
    }

    .menu-item a {
        color: white;
        text-decoration: none;
    }

    .menu-item:hover {
        background-color: #2c3e50;
    }
</style>
