<?php

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM pokemon WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: index.php");
exit();
