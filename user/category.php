<?php
require_once '../config/db.php';

// fetch all categories
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

// check if a category is selected
$cat_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$prompts = [];
$selected_category = null;

if ($cat_id > 0) {
    foreach ($categories as $cat) {
        if ($cat['id'] == $cat_id) {
            $selected_category = $cat;
            break;
        }
    }

    if ($selected_category) {
        $stmt = $conn->prepare("SELECT p.*, c.name AS category_name 
                                FROM prompts p
                                JOIN categories c ON p.category_id = c.id
                                WHERE p.category_id = ?
                                ORDER BY p.created_at DESC");
        $stmt->execute([$cat_id]);
        $prompts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories - PromptGallery</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">
    <style>
        .category-list {
            margin: 20px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center; /* ✅ Center */
        }
        .category-list a {
            background: red;
            color: #fff;
            padding: 8px 14px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .category-list a:hover,
        .category-list a.active {
            background: #cc0000;
        }
        .prompt-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .prompt-card {
            background: #2b2b2b;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
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

    <!-- navbar -->
    <header>
        <div class="logo">PromptGallery</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="category.php" class="active">Categories</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <div class="main-content">
        <h1>Categories</h1>

        <div class="category-list">
            <?php foreach ($categories as $cat): ?>
                <a href="category.php?id=<?= $cat['id'] ?>" 
                   class="<?= $cat_id === (int)$cat['id'] ? 'active' : '' ?>">
                   <?= htmlspecialchars($cat['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if ($selected_category): ?>
            <h2>Prompts in "<?= htmlspecialchars($selected_category['name']) ?>"</h2>
            
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
                            <p><b>Audience:</b> <?= ucfirst($p['audience']) ?></p>
                            <p><?= nl2br(htmlspecialchars($p['prompt_text'])) ?></p>
                            <button class="copy-btn" onclick="copyText('<?= htmlspecialchars(addslashes($p['prompt_text'])) ?>')">Copy</button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No prompts in this category.</p>
                <?php endif; ?>
            </div>
        <?php elseif($cat_id > 0): ?>
            <p>Invalid category selected.</p>
        <?php endif; ?>
    </div>

    <!-- Footer (now active) -->
    <?php include 'footer.php'; ?>

</body>
</html>
