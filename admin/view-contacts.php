<?php
// Include DB connection
include 'db_connect.php';

// Fetch contacts
$query = "SELECT * FROM contacts ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Contacts</title>
    <link rel="stylesheet" href="styles.css"> <!-- optional -->
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #f4f4f4; }
        tr:hover { background: #f9f9f9; }
        .delete-btn {
            background: red; color: white; padding: 5px 10px;
            border: none; cursor: pointer; border-radius: 4px;
        }
    </style>
</head>
<body>

<h2>Contact Messages</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Date</th>
        <th>Action</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['message']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
                <a href="delete-contact.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this contact?');">
                    <button class="delete-btn">Delete</button>
                </a>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
