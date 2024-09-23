<?php
// Démarrage de la session
session_start();

// Détruire toutes les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion ou d'accueil
header('Location: ../index.php');
exit;
?>
