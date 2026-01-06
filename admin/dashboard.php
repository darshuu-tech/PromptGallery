<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 200px;
            height: 100vh;
            background: #111;
            color: #fff;
            padding: 20px;
        }
        .sidebar h2 {
            margin-bottom: 30px;
            font-size: 22px;
            text-align: center;
        }
        .sidebar a {
            display: block;
            text-decoration: none;
            color: #ddd;
            margin: 12px 0;
            padding: 10px 15px;
            border-radius: 6px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: #444;
            color: #fff;
        }

        /* Main content */
        .main-content {
            margin-left: 220px;
            padding: 30px;
        }
        .main-content h2 {
            font-size: 26px;
            margin-bottom: 10px;
        }
        .main-content p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        /* Cards */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card h3 {
            margin: 10px 0;
            font-size: 18px;
        }
        .card a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .card a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="add-prompt.php">➕ Add Prompt</a>
        <a href="view-prompts.php">📋 View Prompts</a>
        <a href="change-password.php">🔐 Change Password</a>
        <a href="logout.php">🚪 Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?> 👋</h2>
        <p>This is your admin dashboard.</p>

        <div class="cards">
            <div class="card">
                <h3>Add New Prompt</h3>
                <a href="add-prompt.php">Go ➕</a>
            </div>
            <div class="card">
                <h3>View All Prompts</h3>
                <a href="view-prompts.php">Go 📋</a>
            </div>
            <div class="card">
                <h3>Change Password</h3>
                <a href="change-password.php">Go 🔐</a>
            </div>
            <div class="card">
                <h3>Logout</h3>
                <a href="logout.php">Go 🚪</a>
            </div>
        </div>
    </div>
</body>
</html>
