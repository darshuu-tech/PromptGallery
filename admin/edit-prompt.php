<?php
session_start();
require_once '../config/db.php';

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit;
}

$prompt_id = $_GET['id'];

// Get categories
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Get prompt data
$stmt = $conn->prepare("SELECT * FROM prompts WHERE id = ?");
$stmt->execute([$prompt_id]);
$prompt = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$prompt) {
    echo "Prompt not found.";
    exit;
}

$message = "";

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $prompt_text = trim($_POST['prompt_text']);
    $category_id = $_POST['category_id'];
    $audience = $_POST['audience'];
    $image_url = $prompt['image_url']; // default to existing image

    // Handle new uploaded image if exists
    if (!empty($_FILES['prompt_image']['name'])) {
        $target_dir = "../uploads/";
        $file_name = time() . '_' . basename($_FILES["prompt_image"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["prompt_image"]["tmp_name"], $target_file)) {
            $image_url = "uploads/" . $file_name; // store relative path
        }
    }

    // Update the prompt
    $update = $conn->prepare("UPDATE prompts SET title = ?, prompt_text = ?, category_id = ?, audience = ?, image_url = ? WHERE id = ?");
    if ($update->execute([$title, $prompt_text, $category_id, $audience, $image_url, $prompt_id])) {
        $message = "✅ Prompt updated successfully!";
        $stmt->execute([$prompt_id]); // Refresh data
        $prompt = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $message = "❌ Failed to update prompt.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Prompt</title>
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
            max-width: 600px;
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

        input[type="text"], textarea, select, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
        }

        img {
            margin: 10px 0;
            border-radius: 6px;
            border: 2px solid #ddd;
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

        .message {
            text-align: center;
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <h2>Edit Prompt</h2>

    <div class="form-container">
        <form method="POST" action="" enctype="multipart/form-data">
            <label>Title:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($prompt['title']) ?>" required>

            <label>Prompt Text:</label>
            <textarea name="prompt_text" rows="5" required><?= htmlspecialchars($prompt['prompt_text']) ?></textarea>

            <label>Category:</label>
            <select name="category_id" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $prompt['category_id'] ? 'selected' : '' ?>>
                        <?= $cat['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Audience:</label>
            <select name="audience">
                <option value="both" <?= $prompt['audience'] === 'both' ? 'selected' : '' ?>>Both</option>
                <option value="men" <?= $prompt['audience'] === 'men' ? 'selected' : '' ?>>Men</option>
                <option value="women" <?= $prompt['audience'] === 'women' ? 'selected' : '' ?>>Women</option>
            </select>

            <label>Current Image:</label>
            <?php if (!empty($prompt['image_url'])): ?>
                <img src="../<?= $prompt['image_url'] ?>" width="120">
            <?php else: ?>
                <p>No image uploaded</p>
            <?php endif; ?>

            <label>Upload New Image (optional):</label>
            <input type="file" name="prompt_image">

            <input type="submit" value="Update Prompt">
        </form>

        <?php if (!empty($message)): ?>
            <p class="message" style="color: <?= strpos($message, '✅') === 0 ? 'green' : 'red' ?>;">
                <?= $message ?>
            </p>
        <?php endif; ?>

        <a href="view-prompts.php" class="btn-back">⬅ Back to Prompts</a>
    </div>

</body>
</html>
