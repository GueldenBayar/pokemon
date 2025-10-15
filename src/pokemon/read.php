<?php

//Alle meine Pokemons aus der Datenbank abrufen
$stmt = $pdo->query("SELECT id, name, caught, type FROM pokemon ORDER BY id ASC");
$pokemons = $stmt->fetchAll();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pokémon</title>
</head>
<body>
    <h1>My Pokédex</h1>
    <p><a href="index.php?action=create">Add new Pokémon</a></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Caught</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($pokemon as $pokemon): ?>
        <tr>
            <td><?= htmlspecialchars($pokemon['id']) ?></td>
            <td><?= htmlspecialchars($pokemon['name'])?></td>
            <td><?= htmlspecialchars($pokemon['type']) ?></td>
            <td><?= $pokemon['caught'] ? 'Ja' : 'Nein' ?></td>
            <td class="actions">
                <a href="index.php?action=edit&id=<?= $pokemon['id'] ?>">Edit</a>
                <a href="index.php?action=delete&id=<?= $pokemon['id'] ?>" onclick="return confirm('You sure?🦍')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
