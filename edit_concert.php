<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: concert.php');
    exit();
}

$venue_id = $_GET['id'];

// Fetch the venue details
try {
    $stmt = $conn->prepare("SELECT * FROM venue WHERE id = :id");
    $stmt->bindParam(':id', $venue_id);
    $stmt->execute();
    $venue = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$venue) {
        echo "concert not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    try {
        $stmt = $conn->prepare("UPDATE venue SET title = :title, description = :description, date = :date WHERE id = :id");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':id', $venue_id);
        $stmt->execute();
        header('Location: concert.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Concert</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>Concert Management System</header>
    <form method="POST">
        <label>Concert Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($venue['title']); ?>" required>
        <label>Concert Description:</label>
        <textarea name="description" required><?= htmlspecialchars($venue['description']); ?></textarea>
        <label>Concert Date:</label>
        <input type="date" name="date" value="<?= $venue['date']; ?>" required>
        <button type="submit">Update Concert</button>
    </form>
</body>
</html>