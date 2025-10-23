<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/functions.php';

// Den "sauberen" URL-Pfad abfangen, z. B. /create oder /edit/5
$path = $_GET['path'] ?? '';
$segments = explode('/', trim($path, '/'));
$action = $segments[0] ?: 'list';
$id = $segments[1] ?? null;


switch ($action) {
    case 'create':
        include __DIR__ . '/../views/pokemon_form.php';
        break;

    case 'edit':
        if ($id) {
            $pokemon = findPokemonById($pdo, (int)$id);
            include __DIR__ . '/../views/pokemon_form.php';
        } else {
            header('Location: /pokemon/public/');
            exit;
        }
        break;

    case 'delete':
        if ($id) {
            include __DIR__ . '/../src/pokemon/delete.php';
        }
        break;

    default:
        $pokemons = findAllPokemons($pdo);
        include __DIR__ . '/../views/pokemon_list.php';
        break;
}

