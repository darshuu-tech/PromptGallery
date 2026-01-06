<?php
session_start();
require_once '../config/db.php';

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch categories for the dropdown
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $prompt_text = trim($_POST['prompt_text']);
    $category_id = $_POST['category_id'];
    $audience = $_POST['audience'];
    $image_url = ''; // default empty

    // Handle image upload if file is selected
    if (!empty($_FILES['prompt_image']['name'])) {
        $target_dir = "../uploads/";
        $file_name = time() . '_' . basename($_FILES["prompt_image"]["name"]);
        $target_file = $target_dir . $file_name;
        $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];

        if (in_array($_FILES["prompt_image"]["type"], $allowed_types)) {
            if (move_uploaded_file($_FILES["prompt_image"]["tmp_name"], $target_file)) {
                $image_url = "uploads/" . $file_name;
            } else {
                $message = "❌ Failed to upload image.";
            }
        } else {
            $message = "❌ Invalid image type. Only JPG, PNG, or WEBP allowed.";
        }
    }

    // Proceed with database insert if no error yet
    if (empty($message)) {
        $insert = $conn->prepare("INSERT INTO prompts (title, prompt_text, category_id, audience, image_url) VALUES (?, ?, ?, ?, ?)");
        if ($insert->execute([$title, $prompt_text, $category_id, $audience, $image_url])) {
            $message = "✅ Prompt added successfully!";
        } else {
            $message = "❌ Failed to add prompt to database.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Prompt</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 25px;
            text-align: center;
            color: #333;
        }

        h3 {
            margin: 20px 0 8px;
            font-size: 16px;
            color: #444;
            border-left: 4px solid #007bff;
            padding-left: 8px;
        }

        input[type="text"],
        textarea,
        select,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            margin-top: 25px;
            width: 100%;
            background: #007bff;
            border: none;
            padding: 12px;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        .message {
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Add New Prompt</h2>

        <form method="POST" action="" enctype="multipart/form-data">
            <h3>Title</h3>
            <input type="text" name="title" required>

            <h3>Prompt Text</h3>
            <textarea name="prompt_text" rows="5" required></textarea>

            <h3>Category</h3>
            <select name="category_id" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>

            <h3>Audience</h3>
            <select name="audience" required>
                <option value="both">Both</option>
                <option value="men">Men</option>
                <option value="women">Women</option>
            </select>

            <h3>Upload Image</h3>
            <input type="file" name="prompt_image" accept="image/*">

            <input type="submit" value="Add Prompt">
        </form>

        <!-- Back Button -->
        <div style="text-align:center; margin-top:15px;">
            <a href="dashboard.php"
                style="display:inline-block; padding:10px 18px; background:#6c757d; color:#fff; 
                      text-decoration:none; border-radius:6px; transition:0.3s;">
                ⬅ Back to Dashboard
            </a>
        </div>

        <?php if (!empty($message)): ?>
            <p class="message <?= strpos($message, '✅') === 0 ? 'success' : 'error' ?>">
                <?= $message ?>
            </p>
        <?php endif; ?>


        <?php if (!empty($message)): ?>
            <p class="message <?= strpos($message, '✅') === 0 ? 'success' : 'error' ?>">
                <?= $message ?>
            </p>
        <?php endif; ?>
    </div>

</body>

</html>