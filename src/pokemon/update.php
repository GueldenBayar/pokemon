<?php
//holt zuerst die Daten des zu bearbeitenden Pokemon (GET) und speichert dann die Änderungen (POST)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE pokemon SET name = ?, type = ?, caught = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $caught = isset($_POST['caught']) ? 1 : 0;
    $stmt->execute([$_POST['name'], $_POST['type'], $caught, $_POST['id']]);

    header("Location: index.php");
    exit();
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
        <button type="submit">
            Save Changes
        </button>

    </form>

</body>
</html>
