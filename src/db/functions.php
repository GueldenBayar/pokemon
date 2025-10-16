<?php
//@param PDO $pso Die aktive Datnebankverbindung
//@return array eine Liste aller Pokemon(mit ID, Name, Caught, Type)

function findAllPokemons(PDO $pdo): array
{
    $stmt = $pdo->query("SELECT id, name, caught, type FROM pokemon ORDER BY id ASC");
    return $stmt->fetchAll();
}

//findet ein einzelnes Pokemon anhand seiner ID
//@param PDO $pdo ist die aktive Datenbankverbindung
//@param int $id Die ID des gesuchten Pokemons
//@return array Das Pokemon als assoziatives Array oder ein leeres Array, wenn nicht gefunden

function findPokemonById(PDO $pdo, int $id): array {
    $stmt = $pdo->prepare("SELECT * FROM pokemon WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch() ?: [];
}

//erstellt neuen Pokemon Eintrag in der Datenbank
//@param PDO $pdo Die aktive Datenbankverbindung
//@param string $name der Name des Pokemons
//@param string $type der Typ des Pokemons (muss in ENUM Liste existieren)
//@param bool $caught Status, ob das Pokemon gefangen wurde (true=1, false=0)
//@return bool True bei Erfolg, False bei Misserfolg der Ausführung

function createPokemon(PDO $pdo, string $name, string $type, bool $caught): bool {

    $stmt = $pdo->prepare("
    INSERT INTO pokemon (name, type, caught)
    VALUES (?, ?, ?)
    ");
    return $stmt->execute([$name, $type, $caught ? 1 : 0]);
}

//Aktualisiert bestehenden Pokemon Eintrag
//@param PDO $pdo Die aktive Datenbankverbindung
//@param int $id Die ID des zu aktualisierenden Pokemons
//@param string $name Der neue Name
//@param string $type Der neue Type
//@param bool $caught Der neue Gefangen Status
//@return bool True bei Erfolg, False bei Misserfolg der Ausführung

function updatePokemon(PDO $pdo, int $id, string $name, string $type, bool $caught): bool {
    $stmt = $pdo->prepare("
    UPDATE pokemon
    SET name = ?, type = ?, caught = ?
    WHERE id = ?
    ");
    return $stmt->execute([$name, $type, $caught, $id]);
}

//Löscht Pokemon Eintrag anhand der ID
//@param PDO $pdo Die aktive Datenverbindung
//@param int $id Die ID des zu löschenden Pokemons.
//@return bool True bei Erfolg, False bei Misserfolg der Ausführung

function deletePokemon(PDO $pdo, int $id): bool {
    $stmt = $pdo->prepare("DELETE FROM pokemon WHERE id = ?");
    return $stmt->execute([$id]);
}

//Ruft alle erlaubten ENUM-Werte für die Pokemon Typ Spalte ab

//@param PDO $pdo Die aktive Datenbankverbindung
//@return array Eine Liste von erlaubten Typen-Strings

function getPokemonTypes(PDO $pdo): array {

    try {
        $smt = $pdo->query("SHOW COLUMNS FROM pokemon WHERE Field = 'type'");
        $column_info = $stmt->fetch();

        if (empty($column_info['Type'])) {
            return [];
        }

        //ENUM-String parsen: "enum('Normal', 'Fire', 'Water', ..)"
        if (preg_match_all("/'([^']+)'/", $column_info['Type'], $matches)) {
            return $matches[1];
        }
    } catch (PDOException $e) {
        error_log("Failed to load Pokemon types: " . $e->getMessage());
    }
    return[];
}