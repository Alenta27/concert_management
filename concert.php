<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$stmt = $conn->prepare("SELECT * FROM venue");
$stmt->execute();
$venue = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONCERTS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>Concert Management System</header>
    <div class="nav">
        <a href="create_concert.php">Create Concert</a>
        <a href="logout.php">Logout</a>
    </div>
    <ul>
        <?php foreach ($venue as $venue): ?>
            <li>
                <strong><?= htmlspecialchars($venue['title']); ?></strong> (<?= $venue['date']; ?>)
                <a href="edit_concert.php?id=<?= $venue['id']; ?>">Edit</a>
                <a href="delete_concert.php?id=<?= $venue['id']; ?>">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>