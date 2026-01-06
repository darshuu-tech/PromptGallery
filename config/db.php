<?php
$host = "localhost";
$dbname = "prompt_gallery";
$username = "root";
$password = ""; // leave empty if using XAMPP default

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Enable error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Database connected successfully!";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>