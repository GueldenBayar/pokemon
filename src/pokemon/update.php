<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../functions.php';

$id     = (int)($_POST['id'] ?? 0);
$name   = $_POST['name'] ?? '';
$type   = $_POST['type'] ?? '';
$caught = isset($_POST['caught']);

if ($id && $name && $type) {
    updatePokemon($pdo, $id, $name, $type, $caught);
}

header('Location: /pokemon/public/index.php');
exit;
