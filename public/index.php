<?php
//mein Controller the one and only

require_once __DIR__ . '/../config/config.php';

//entscheiden welche Aktion ausgeführt werden soll anhand URL Parameters

$action =$_GET['action'] ?? 'read'; //meine Standardaktion ist read

switch ($action) {
    case 'create':
        require __DIR__ . '/../src/db/pokemon/create.php';
        break;
    case 'edit':
        require __DIR__ . '/../src/db/pokemon/update.php';
        break;
    case 'delete':
        require __DIR__ . '/../src/db/pokemon/delete.php';
        break;
    case 'read':
        require __DIR__ . '/../src/db/pokemon/read.php';
        break;
}