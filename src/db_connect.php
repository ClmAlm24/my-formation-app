<?php
// Configuration de la connexion à la base de données
$host = 'localhost';
$dbname = 'plateforme_vulnerabilites'; // Remplacez par le nom de votre base de données
$username = 'myuser'; // Remplacez par votre nom d'utilisateur
$password = 'mysql$'; // Remplacez par votre mot de passe

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Activer les erreurs PDO en cas de problème
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}
?>
