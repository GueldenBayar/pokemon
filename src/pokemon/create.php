<?php
//wurde mein formular abgesendet? wenn ja darf code innen weiterarbeiten
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Schreib-Befehl für meine DB, neuer Eintrag mit name, type, caught, Fragezeichen sind Platzhalter -> da kommen später echte Daten rein
    $sql = "INSERT INTO pokemon (name, type, caught) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    $caught = isset($_POST['caught']) ? 1 : 0;

    //jetzt werden die Daten eingetragen
    $stmt->execute([$_POST['name'], $_POST['type'], $caught]);

    //Nach dem Speichern zurück zur Hauptseite
    header("Location: index.php");
    exit();
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
                <option value="">-- choose type --</option>
                <option value="Normal">Normal</option>
                <option value="Fire">Fire</option>
                <option value="Water">Water</option>
                <option value="Grass">Grass</option>
                <option value="Electric">Electric</option>
                <option value="Ice">Ice</option>
                <option value="Fighting">Fighting</option>
                <option value="Poison">Poison</option>
                <option value="Ground">Ground</option>
                <option value="Flying">Flying</option>
                <option value="Psychic">Psychic</option>
                <option value="Bug">Bug</option>
                <option value="Rock">Rock</option>
                <option value="Ghost">Ghost</option>
                <option value="Dragon">Dragon</option>
                <option value="Dark">Dark</option>
                <option value="Steel">Steel</option>
                <option value="Fairy">Fairy</option>
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
