<?php

//Konfiguration

$dbHost = '10.101.105.110';
$dbName = 'pokemon';
$dbUser = 'codingstorm';
$dbPass = 'passwort';

//Verbindung zur Datenbank

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fehler bei der Datenbankverbindung: ". $e->getMessage());
}

echo "Starte Import der ersten 150 Pokemon...\n";

for ($i = 1; $i <= 150; $i++) {
    //API URL mit der aktuellen ID($i) zusammenbauen
    $apiUrl = "https://pokeapi.co/api/v2/pokemon/" . $i;
    echo "Rufe Daten für Pokemon #$i ab....";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'MeinPokemonImporter/1.0');
    $jsonResponse = curl_exec($ch);
    curl_close($ch);

    //JSON-Antwort in ein php Array umwandeln
    $data = json_decode($jsonResponse, true);

    //prüfen, ob Daten gültig
    if (!$data || !isset($data['name'])) {
        echo "Fehler: Konnte keine Daten finden ☠️☠️☠️.\n";
        continue; //mach mit nächstem Pokemon weiter
    }

    //die relevanten Daten aus dem Array extrahieren
    $name = ucfirst($data['name']);
    $type = ucfirst($data['types'][0]['type']['name']);

    //SQL-Statement vorbereiten
    $sql = "INSERT INTO pokemon (id, name, caught, type) VALUES (:id, :name, :caught, :type)";
    $stmt = $pdo->prepare($sql);

    //Daten in Datenbank einfügen
    try {
        $stmt->execute([
            ':id' => $i,
            ':name' => $name,
            ':caught' => 0,
            ':type' => $type
        ]);
        echo "-> Erfolgreich als '$name' (Typ: $type) hinzugefügt. \n";
    } catch (PDOException $e) {
        //Falls Typ nicht in enum existiert:
        echo "-> Fehler beim Einfügen: " . $e->getMessage() . "\n";
    }

    //Kleine Pause (50 Millisek), um die API nicht zu überlasten, apperently guter Stil
    usleep(50000);
}

echo "\nImport abgeschlossen!\n";