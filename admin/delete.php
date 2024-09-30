<?php
include '../includes/db.php';

$id = $_GET['id'];
$query = $conn->prepare("DELETE FROM relojes WHERE id = ?");
$query->execute([$id]);

header('Location: index.php');
?>

