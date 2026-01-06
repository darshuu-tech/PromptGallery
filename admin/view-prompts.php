<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all prompts with category name
$sql = "SELECT prompts.*, categories.name AS category_name 
        FROM prompts 
        JOIN categories ON prompts.category_id = categories.id 
        ORDER BY prompts.created_at DESC";
$prompts = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Prompts</title>
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
            color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            color: #333;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
        }

        th {
            background: #4c3bcf;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        tr:hover {
            background: #ddd;
        }

        img {
            border-radius: 6px;
        }

        a {
            text-decoration: none;
            font-weight: bold;
            margin: 0 5px;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
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

    <h2>All Prompts</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Prompt</th>
            <th>Category</th>
            <th>Audience</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($prompts as $prompt): ?>
        <tr>
            <td><?= $prompt['id'] ?></td>
            <td><?= htmlspecialchars($prompt['title']) ?></td>
            <td><?= nl2br(htmlspecialchars($prompt['prompt_text'])) ?></td>
            <td><?= htmlspecialchars($prompt['category_name']) ?></td>
            <td><?= ucfirst($prompt['audience']) ?></td>
            <td>
                <?php if (!empty($prompt['image_url'])): ?>
                    <img src="../<?= $prompt['image_url'] ?>" width="80" alt="Prompt Image">
                <?php else: ?>
                    No image
                <?php endif; ?>
            </td>
            <td>
                <a href="edit-prompt.php?id=<?= $prompt['id'] ?>" style="color: #007bff;">✏️ Edit</a> |
                <a href="delete-prompt.php?id=<?= $prompt['id'] ?>" onclick="return confirm('Are you sure to delete?')" style="color: #dc3545;">🗑️ Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

    <div style="text-align:center;">
        <a href="dashboard.php" class="btn-back">⬅ Back to Dashboard</a>
    </div>

</body>
</html>
