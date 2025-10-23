<?php
$isEdit = isset($pokemon);
$action = $isEdit ? '/pokemon/src/pokemon/update.php' : '/pokemon/src/pokemon/create.php';
?>

<h1><?= $isEdit ? 'Edit Pokémon' : 'Add Pokémon' ?></h1>

<form method="post" action="<?= $action ?>" class="pokemon-form">
    <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($pokemon['id']) ?>">
    <?php endif; ?>

    <label>
        Name:
        <input type="text" name="name" value="<?= htmlspecialchars($pokemon['name'] ?? '') ?>" required>
    </label>

    <label>
        Type:
        <input type="text" name="type" value="<?= htmlspecialchars($pokemon['type'] ?? '') ?>" required>
    </label>

    <label class="checkbox">
        <input type="checkbox" name="caught" <?= !empty($pokemon['caught']) ? 'checked' : '' ?>>
        Caught
    </label>

    <input type="submit" value="<?= $isEdit ? 'Update' : 'Add' ?>">
    <a href="/pokemon/public/index.php" class="button">Back</a>
</form>
