<?php
//wurde mein formular abgesendet? wenn ja darf code innen weiterarbeiten
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Schreib-Befehl für meine DB, neuer Eintrag mit name, type, caught, Fragezeichen sind Platzhalter -> da kommen später echte Daten rein
    $sql = "INSERT INTO pokemon (name, type, caught) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $caught = isset($_POST['caught']) ? 1 : 0;
    $pokemon_name = htmlspecialchars($_POST['name']);
     try {
         //$stmt abfeuern, daten werden eingetragen
         $stmt->execute([$_POST['name'], $_POST['type'], $caught]);
         $_SESSION['message'] = '🎉 Pokémon "' . htmlspecialchars($_POST['name']) . '" erfolgreich erstellt!';
         header("Location: index.php?action=read");
         exit();
     } catch (PDOException $e) {
         $_SESSION['error'] = 'Fehler beim Speichern von "' . $pokemon_name .'": ' . $e->getMessage();

         header("Location: index.php?action=create");
         exit();
     }
}

$pokemon_types = [];
//abrufen aller erlaubten Werte für die Spalte 'type' aus der Datenbank
try {
    //Dieser SQL Befehl ist Standard, um ENUM-Werte abzurufen
    //Er liefert eine Beschreibung der Spalte 'type'
    $stmt = $pdo->query("SHOW COLUMNS FROM pokemon WHERE Field='type'");
    $column_info = $stmt->fetch(PDO::FETCH_ASSOC);

    //ENUM String sieht etwa so aus "enum('normal', 'fire', 'water')"
    $enum_string = $column_info['Type'];

    //Klammern, Anführungszeichen entfernen, um ein Array für Type zu erhalten
    preg_match_all("/'([^']+)'/", $enum_string, $matches);
    $pokemon_types = $matches[1] ?? [];
} catch (PDOException $e) {
    //Falls Datenbankverbindung fehlschlägt
    $pokemon_types = ['Error: Database failed to load types'];
    error_log("Failed to load Pokemon types: " . $e->getMessage());
}
//wenn das formular noch nicht abgeschickt wurde, zeigt es HTML an
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Pokemon</title>
</head>
<body>
    <h1>Add new Pokemon</h1>

    <form action="index.php?action=create" method="post">

        <p>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
        </p>

        <p>
            <label for="type">Type:</label>
            <select name="type" id="type" required>
                <?php foreach ($pokemon_types as $type): ?>
                <option value="<?= htmlspecialchars($type) ?>">
                    <?= htmlspecialchars($type) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="caught">
                <input type="checkbox" name="caught" id="caught">
                Caught?
            </label>
        </p>

        <button type="submit">Save</button>
    </form>
</body>
</html>
