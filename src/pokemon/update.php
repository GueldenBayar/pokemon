<?php
//holt zuerst die Daten des zu bearbeitenden Pokemon (GET) und speichert dann die Änderungen (POST)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //1. Prüfen, ob alle notwendigen Keys vorhanden sind
    if (!isset($_POST['name'], $_POST['type'], $_POST['id'])) {
        //Fehlermeldung, falls ein Wert fehlt
        die("Error: Name, Type or ID is missing!!!");
    }


    $sql = "UPDATE pokemon SET name = ?, type = ?, caught = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    //Wert für caught korrekt ermitteln
    //wenn checkbox angekreuzt -> name im POST gesendet, sonst nicht
    $caught = isset($_POST['caught']) ? 1 : 0;

    try {
        $stmt->execute([
                $_POST['name'],
                $_POST['type'],
                $caught,
                $_POST['id']
        ]);

        //auf Lese-Seite umleiten
        header("Location: index.php?action=read");
        exit();
    } catch (PDOException $e) {
        //bei Datenbank Fehlern, zB falscher Type-Wert
        die("Fehler beim Speichern: " . $e->getMessage());;
    }
}

//Hole die ID aus der URL und lade die Daten des Pokemon
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM pokemon WHERE id = ?");
$stmt->execute([$id]);
$pokemon = $stmt->fetch();

$pokemon_types = [];
try {
    //SQL-Befehl, type daten abfragen
    $stmt_types = $pdo->query("SHOW COLUMNS FROM pokemon WHERE Field = 'type'");
    $column_info =$stmt_types->fetch(PDO::FETCH_ASSOC);

    if (preg_match_all("/'([^']+)'/", $column_info['Type'], $matches)) {
        $pokemon_types = $matches[1];
    }
} catch (Exception $e) {
    error_log("Failed to load Pokemon Types!" . $e->getMessage());
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Pokemon</title>
</head>
<body>
    <h1><?= htmlspecialchars($pokemon['name']) ?>edit</h1>

    <form action="index.php?action=edit&id=<?= $pokemon['id'] ?>"method="post">
        <input type="hidden" name="id" value="<?= $pokemon['id'] ?>">

        <p>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($pokemon['name']) ?>" required>
        </p>
        <p>
            <label for="type">Type:</label>
            <select name="type" id="type" required>
                <?php foreach ($pokemon_types as $type): ?>
                <option value="<?= htmlspecialchars($type) ?>">
                    <?= ($pokemon['type'] === $type) ? 'selected' : '' ?>
                    <?= htmlspecialchars($type) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="caught">Caught?</label>
            <input type="checkbox" name="caught" id="caught" <?= $pokemon['caught'] ? 'checked' : '' ?>>
        </p>
        <button type="submit">
            Save Changes
        </button>

    </form>
</body>
</html>
