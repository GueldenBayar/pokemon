<?php
$dbHost = '10.101.105.110';
$dbName = 'pokemon';
$dbUser = 'codingstorm';
$dbPass = 'passwort';
$charset = 'utf8mb4';

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
$options = [
    //Fehler als Exceptions werfen
    PDO::ATTR_ERRMODE             => PDO::ERRMODE_EXCEPTION,
    // Daten als assoziative Arrays abrufen
    PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC,
    // Emulation ausschalten für Native Prepared Statements
    PDO::ATTR_EMULATE_PREPARES    => false
];

//pdo Verbindung herstellen
try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}