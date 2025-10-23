<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PokéMoN</title>
</head>
<body>
<h1>PokéMoN</h1>

<p>
    <a href="/pokemon/create">Add Pokémon</a> |
    <a href="/pokemon/import">Import Pokémon</a>
</p>

<table border="1" cellpadding="5">
    <tr><th>ID</th><th>Name</th><th>Type</th><th>Caught</th><th>Actions</th></tr>
    <?php foreach ($pokemons as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['id']) ?></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= htmlspecialchars($p['type']) ?></td>
            <td><?= $p['caught'] ? '✅' : '❌' ?></td>
            <td>
                <a href="/pokemon/edit/<?= $p['id'] ?>">Edit</a> |
                <a href="/pokemon/delete/<?= $p['id'] ?>" onclick="return confirm('Delete this Pokémon?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
