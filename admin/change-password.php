<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$message = "";

// Fetch current admin data
$admin_id = $_SESSION['admin_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    // Get current password hash from DB
    $stmt = $conn->prepare("SELECT password FROM admins WHERE id = ?");
    $stmt->execute([$admin_id]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify current password
    if (!password_verify($current, $admin['password'])) {
        $message = "❌ Current password is incorrect!";
    } elseif ($new !== $confirm) {
        $message = "❌ New password and confirmation do not match!";
    } else {
        // Update new password
        $newHash = password_hash($new, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE admins SET password = ? WHERE id = ?");
        $update->execute([$newHash, $admin_id]);
        $message = "✅ Password updated successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #6a5acd;
            margin: 0;
            padding: 20px;
            color: #fff;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container {
            max-width: 500px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            color: #333;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        label {
            font-weight: bold;
            display: block;
            margin: 12px 0 6px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #4c3bcf;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background: #3726a6;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-top: 15px;
        }

        .btn-back {
            display: block;
            text-align: center;
            margin-top: 15px;
            padding: 10px 18px;
            background: #6c757d;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.3s;
        }

        .btn-back:hover {
            background: #565e64;
        }
    </style>
</head>
<body>

    <h2>Change Password</h2>

    <div class="form-container">
        <form method="POST" action="">
            <label>Current Password:</label>
            <input type="password" name="current_password" required>

            <label>New Password:</label>
            <input type="password" name="new_password" required>

            <label>Confirm New Password:</label>
            <input type="password" name="confirm_password" required>

            <input type="submit" value="Change Password">
        </form>

        <?php if (!empty($message)): ?>
            <p class="message" style="color: <?= strpos($message, '✅') === 0 ? 'green' : 'red' ?>;">
                <?= $message ?>
            </p>
        <?php endif; ?>

        <a href="dashboard.php" class="btn-back">⬅ Back to Dashboard</a>
    </div>

</body>
</html>
