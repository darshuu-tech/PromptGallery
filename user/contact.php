<?php
require_once '../config/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $msg = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($msg)) {
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $msg])) {
            $message = "<p class='success'>✅ Thank you for contacting us! We’ll get back to you soon.</p>";
        } else {
            $message = "<p class='error'>❌ Something went wrong. Please try again.</p>";
        }
    } else {
        $message = "<p class='error'>⚠️ All fields are required.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Contact Us - PromptGallery</title>

    <!-- CACHE-BUSTING stylesheet link (as you requested) -->
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">

    <style>
        /* Contact box styling to match site frames */
        .main-content { padding: 40px 20px; }
        .contact-form {
            max-width: 800px;
            width: 90%;
            margin: 40px auto;
            background: #2b2b2b;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.45);
        }
        .contact-form h1 {
            margin-bottom: 20px;
            color: #ff3333;
            text-align: center;
            font-size: 36px;
        }
        .contact-form label {
            font-weight: 700;
            display: block;
            margin-bottom: 6px;
            color: #e6e6e6;
        }
        .contact-form input,
        .contact-form textarea {
            width: 100%;
            margin-bottom: 18px;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #b30000;
            background: #333;
            color: #fff;
            font-size: 15px;
            box-sizing: border-box;
        }
        .contact-form input:focus,
        .contact-form textarea:focus {
            outline: none;
            border-color: #ff4d4d;
            box-shadow: 0 0 0 3px rgba(255,77,77,0.06);
        }
        .contact-form button {
            padding: 12px 24px;
            background: #ff0000;
            border: none;
            color: white;
            font-weight: 700;
            border-radius: 8px;
            cursor: pointer;
            transition: background .15s ease;
        }
        .contact-form button:hover { background: #cc0000; }
        .success, .error {
            text-align: center;
            margin-bottom: 15px;
            font-weight: 700;
        }
        .success { color: #4CAF50; }
        .error { color: #ff3333; }

        /* small screens */
        @media (max-width: 520px) {
            .contact-form { padding: 20px; }
            .contact-form h1 { font-size: 28px; }
        }
    </style>
</head>
<body>

    <!-- Header / Navbar (same structure as index.php) -->
    <header>
        <div class="logo">PromptGallery</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="category.php">Categories</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php" class="active">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main content -->
    <div class="main-content">
        <div class="contact-form">
            <h1>Contact Us</h1>

            <?= $message ?>

            <form method="POST" action="">
                <label for="name" style="text-align: left;">Name:</label>
                <input id="name" type="text" name="name" required>

                <label for="email" style="text-align: left;">Email:</label>
                <input id="email" type="email" name="email" required>

                <label for="message" style="text-align: left;">Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <div style="text-align:center; margin-top:10px;">
                    <button type="submit">Send Message</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

</body>
</html>
