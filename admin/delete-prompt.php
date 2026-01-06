<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Check if ID is passed
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the prompt
    $stmt = $conn->prepare("DELETE FROM prompts WHERE id = ?");
    $stmt->execute([$id]);

    // Redirect back to view-prompts
    header("Location: view-prompts.php");
    exit;
} else {
    echo "Invalid request.";
}
?>