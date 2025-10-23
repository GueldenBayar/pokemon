<?php
require_once __DIR__ . '/../config/config.php';

echo "<h3>Starting import of the first 150 Pokémon...</h3>";

// Stelle sicher, dass die Tabelle existiert
$pdo->exec("
    CREATE TABLE IF NOT EXISTS pokemon (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        caught BOOLEAN NOT NULL DEFAULT 0,
        type VARCHAR(100) NOT NULL
    )
");

for ($i = 1; $i <= 150; $i++) {
    $apiURL = "https://pokeapi.co/api/v2/pokemon/$i";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'MyPokemonImporter/1.0');
    $json = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($json, true);

    // Validierung
    if (!$data || !isset($data['name'])) {
        echo "❌ Error: Could not fetch Pokémon #$i<br>";
        continue;
    }

    $name = ucfirst($data['name']);

    // Mehrere Typen in einem String zusammenfassen (z. B. "water/flying")
    $types = array_map(fn($t) => $t['type']['name'], $data['types']);
    $typeString = implode('/', $types);

    try {
        // Prüfen, ob Pokémon schon existiert
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM pokemon WHERE name = ?");
        $checkStmt->execute([$name]);
        $exists = $checkStmt->fetchColumn();

        if ($exists) {
            echo "⚠️ Skipped: $name already exists<br>";
            continue;
        }

        $stmt = $pdo->prepare("INSERT INTO pokemon (name, type, caught) VALUES (?, ?, 0)");
        $stmt->execute([$name, $typeString]);

        echo "✅ Imported: $name ($typeString)<br>";
    } catch (PDOException $e) {
        echo "❌ DB Error on $name: " . htmlspecialchars($e->getMessage()) . "<br>";
    }

    // Kleine Pause, um API nicht zu überlasten
    usleep(200000); // 0.2 Sekunden
}

echo "<br><strong>✅ Import finished!</strong>";
