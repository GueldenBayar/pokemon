<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO pokemon (name, type, caught) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $caught = isset($_POST['caught']) ? 1 : 0;
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
        <button type="submit">Save</button>
    </form>
</body>
</html>
