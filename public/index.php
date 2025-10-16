<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>⭐Pokemon⭐</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300..700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Fira Code", sans-serif;
        }
    </style>
</head>
<body>

</body>
</html>


<?php

//for debugging display this:
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


//mein Controller the one and only

require_once __DIR__ . '/../config/config.php';

//entscheiden welche Aktion ausgeführt werden soll anhand URL Parameters

$action =$_GET['action'] ?? 'home'; //meine Standardaktion ist home

switch ($action) {
    case 'read':
        require __DIR__ . '/../src/pokemon/read.php';
        break;
    case 'create':
        require __DIR__ . '/../src/pokemon/create.php';
        break;
    case 'edit':
        require __DIR__ . '/../src/pokemon/update.php';
        break;
    case 'delete':
        require __DIR__ . '/../src/pokemon/delete.php';
        break;
    case 'single':
        require __DIR__ . '/../src/pokemon/singlePokemon.php';
        break;
    case 'home':
    default:
        require __DIR__ . '/../view/homepage.php';
        break;
}