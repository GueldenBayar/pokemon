<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../functions.php';

$id = (int)($_GET['id'] ?? 0);
if ($id) {
    deletePokemon($pdo, $id);
}
header('Location: /pokemon/public/index.php');
exit;
