<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>About Us - PromptGallery</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">
</head>

<body>

    <!-- Header -->
    <header>
        <div class="logo">PromptGallery</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="category.php">Categories</a></li>
                <li><a href="about.php" class="active">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <h1>About PromptGallery</h1>

        <p>
            PromptGallery is a collection of high-quality AI prompts designed for creators, developers,
            and learners. Our goal is to help you discover, share, and use prompts that make AI interactions
            better and more creative.
        </p>

        <!-- ✅ Added extra helpful points -->
        <div style="max-width:700px; margin:25px auto; text-align:left; color:#000;">
            <h3 style="color:#000; margin-bottom:10px;">Usage Tips:</h3>
            <ul style="line-height:1.6; font-size:16px;">
                <li>👉 Try these prompts in top AI tools like ChatGPT, Gemini AI, Claude, and more.</li>
                <li>👉 Upload your image in a normal pose for best results.</li>
                <li>👉 Avoid wearing sunglasses or heavy filters when using image-based prompts.</li>
                <li>👉 Use clear lighting and centered framing for face prompts.</li>
                <li>👉 Customize prompts to match your creative style for better output.</li>
                <li>👉 PromptGallery is currently in a testing phase, but all prompts are fully functional — and many more prompts with additional categories will be added soon.</li>
            </ul>
        </div>

    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
