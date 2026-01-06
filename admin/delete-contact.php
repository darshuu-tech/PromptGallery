<?php
include 'db_connect.php';

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM contacts WHERE id=$id";
    if(mysqli_query($conn, $query)) {
        header("Location: view-contacts.php?msg=deleted");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>
