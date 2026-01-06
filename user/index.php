<?php
// connect db
require_once '../config/db.php';

// fetch prompts with category
$query = "SELECT p.*, c.name AS category_name 
          FROM prompts p
          JOIN categories c ON p.category_id = c.id
          ORDER BY p.created_at DESC";
$prompts = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Prompt Gallery - Home</title>
    <!-- Use only the global assets style for navbar consistency -->
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">
    <style>
        /* simple card grid */
        .prompt-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .prompt-card {
            background: #2b2b2bff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .prompt-card img {
            width: 100%;
            height: 220px;
            object-fit: contain;
            background: #1a1a1a;
            border-radius: 8px;
            padding: 4px;
        }

        .prompt-card h3 {
            margin: 10px 0;
            font-size: 18px;
            color: #ff3333;
        }

        .prompt-card p {
            font-size: 14px;
            line-height: 1.4;
            color: #ccc;
        }

        .copy-btn {
            margin-top: 10px;
            background: #e60000;
            color: #fff;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .copy-btn:hover {
            background: #cc0000;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <header>
        <div class="logo">PromptGallery</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="category.php">Categories</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Welcome to PromptGallery</h1>
        <p>Explore trending ChatGPT prompts like Ghibli Art, Portraits, and more — all categorized and ready to copy!</p>

        <div class="prompt-grid">
            <?php if ($prompts): ?>
                <?php foreach ($prompts as $p): ?>
                    <div class="prompt-card">
                        <?php if (!empty($p['image_url'])): ?>
                            <img src="../<?= htmlspecialchars($p['image_url']) ?>" alt="Prompt">
                        <?php else: ?>
                            <img src="../assets/images/no-image.png" alt="No Image">
                        <?php endif; ?>

                        <h3><?= htmlspecialchars($p['title']) ?></h3>
                        <p><b>Category:</b> <?= htmlspecialchars($p['category_name']) ?></p>
                        <p><b>Audience:</b> <?= ucfirst($p['audience']) ?></p>
                        <p><?= nl2br(htmlspecialchars($p['prompt_text'])) ?></p>
                        <button class="copy-btn" onclick="copyText('<?= htmlspecialchars(addslashes($p['prompt_text'])) ?>')">Copy</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No prompts available yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Script -->
    <script>
        function copyText(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert("Prompt copied!");
            });
        }
    </script>

</body>
</html>
