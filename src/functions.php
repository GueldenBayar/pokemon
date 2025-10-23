<?php
function findAllPokemons(PDO $pdo): array {
    $stmt = $pdo->query("SELECT * FROM pokemon ORDER BY id ASC");
    return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
}


function findPokemonById(PDO $pdo, int $id): array {
    $stmt = $pdo->prepare("SELECT * FROM pokemon WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch() ?: [];
}

function createPokemon(PDO $pdo, string $name, string $type, bool $caught): bool {
    $stmt = $pdo->prepare("INSERT INTO pokemon (name, type, caught) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $type, $caught ? 1 : 0]);
}

function updatePokemon(PDO $pdo, int $id, string $name, string $type, bool $caught): bool {
    $stmt = $pdo->prepare("UPDATE pokemon SET name = ?, type = ?, caught = ? WHERE id = ?");
    return $stmt->execute([$name, $type, $caught ? 1 : 0, $id]);
}

function deletePokemon(PDO $pdo, int $id): bool {
    $stmt = $pdo->prepare("DELETE FROM pokemon WHERE id = ?");
    return $stmt->execute([$id]);
}
