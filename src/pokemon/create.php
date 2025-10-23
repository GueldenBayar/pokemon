<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../functions.php';

$name   = $_POST['name'] ?? '';
$type   = $_POST['type'] ?? '';
$caught = isset($_POST['caught']);

if ($name && $type) {
    createPokemon($pdo, $name, $type, $caught);
}

header('Location: /pokemon/public/index.php');
exit;
