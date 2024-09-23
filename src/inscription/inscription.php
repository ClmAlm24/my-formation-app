<?php
// Démarrage de la session pour gérer les messages d'erreur
session_start();

// Inclure le fichier de connexion à la base de données
require '../db_connect.php';

// Vérification que le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et validation des champs du formulaire
    $email = trim($_POST['email']);
    $pseudo = trim($_POST['pseudo']);
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];

    // Vérification des erreurs
    if (empty($email) || empty($pseudo) || empty($password) || empty($c_password)) {
        $_SESSION['error'] = "Tous les champs sont requis.";
        header('Location: ./index.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "L'adresse email n'est pas valide.";
        header('Location: ./index.php');
        exit;
    }

    if ($password !== $c_password) {
        $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
        header('Location: ./index.php');
        exit;
    }

    // Vérification si l'email ou le pseudo existent déjà dans la base de données
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR pseudo = :pseudo");
    $stmt->execute(['email' => $email, 'pseudo' => $pseudo]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $_SESSION['error'] = "L'email ou le pseudo sont déjà utilisés.";
        header('Location: ./index.php');
        exit;
    }

    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertion de l'utilisateur dans la base de données avec une requête paramétrée
    $stmt = $pdo->prepare("INSERT INTO users (email, pseudo, password) VALUES (:email, :pseudo, :password)");
    $stmt->execute([
        'email' => $email,
        'pseudo' => $pseudo,
        'password' => $hashedPassword
    ]);

    // Redirection après l'inscription réussie
    $_SESSION['success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
    header('Location: ../'); // Page de connexion
    exit;
}
?>
