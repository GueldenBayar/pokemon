<?php include __DIR__ . '/header.php';?>

<h1>PokéMoN</h1>

<a href="/public/index.php?path=create" class="button">Add Pokémon</a>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Type</th>
        <th>Caught</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($pokemons)): ?>
    <?php foreach ($pokemons as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['id']) ?></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= htmlspecialchars($p['type']) ?></td>
            <td><?= $p['caught'] ? '✅' : '❌' ?></td>
            <td>
                <a href="/pokemon/public/index.php?path=edit/<?= $p['id'] ?>" class="button">Edit</a>
                <a href="/src/pokemon/delete.php?id=<?= $p['id'] ?>" class="button" style="background:#dc3545;">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php else: ?>
    <tr>
        <td colspan="5">No Pokemon found.</td>
    </tr>
    <?php endif; ?>
    </tbody>
</table>
