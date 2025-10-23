<!doctype html>
<html lang="en">
<head><meta charset="UTF-8"><title><?= isset($pokemon) ? 'Edit' : 'Create' ?> Pokémon</title></head>
<body>
<h1><?= isset($pokemon) ? 'Edit' : 'Create' ?> Pokémon</h1>

<form method="post" action="/pokemon/<?= isset($pokemon) ? 'update' : 'create' ?>">

    <?php if (isset($pokemon)): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($pokemon['id']) ?>">
    <?php endif; ?>

    <label>Name:</label><br>
    <input type="text" name="name" required value="<?= $pokemon['name'] ?? '' ?>"><br>

    <label>Type:</label><br>
    <input type="text" name="type" required value="<?= $pokemon['type'] ?? '' ?>"><br>

    <label>Caught:</label>
    <input type="checkbox" name="caught" <?= !empty($pokemon['caught']) ? 'checked' : '' ?>><br><br>

    <button type="submit"><?= isset($pokemon) ? 'Update' : 'Create' ?></button>
</form>

<p><a href="../public/index.php">← Back</a></p>
</body>
</html>
