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

try {
    $stmt = $conn->prepare("DELETE FROM venue WHERE id = :id");
    $stmt->bindParam(':id', $venue_id);
    $stmt->execute();
    header('Location: concert.php');
    exit();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>