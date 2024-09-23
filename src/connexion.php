<?php
//connexion.php
// Démarrage de la session pour gérer les messages d'erreur
session_start();

// Inclure le fichier de connexion à la base de données
require 'db_connect.php';

// Vérification que le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et validation des champs du formulaire
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Vérification des erreurs
    $errors = [];
    if (empty($email) || empty($password)) {
        $errors[] = "Tous les champs sont requis.";
    }

    // Vérification si l'email existe dans la base de données
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
        $errors[] = "Email ou mot de passe incorrect.";
    }

    // Si pas d'erreurs, générer le token d'authentification
    if (empty($errors)) {
        $token = bin2hex(random_bytes(16));
        $expiration = date('Y-m-d H:i:s', strtotime('+3 hour'));

        // Insertion du token dans la base de données
        $stmt = $pdo->prepare("INSERT INTO auth_tokens (user_id, token, expiration) VALUES (:user_id, :token, :expiration)");
        $stmt->execute([
            'user_id' => $user['id'],
            'token' => $token,
            'expiration' => $expiration
        ]);

        // Stockage du token dans la session
        $_SESSION['token'] = $token;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['pseudo'] = $user['pseudo']; // Assurez-vous que 'username' est le nom du champ contenant le pseudo dans votre base de données

        // Stocker un message de succès dans la session (si vous souhaitez l'utiliser)
        $_SESSION['success'] = "Connexion réussie !";

        // Redirection vers la page d'accueil ou tableau de bord
        header('Location: ./home/');
        exit;
    } else {
        // Si des erreurs sont présentes, les stocker dans la session
        $_SESSION['errors'] = $errors;
        // Redirection vers la page d'accueil ou tableau de bord avec les erreurs
        header('Location: ./index.php');
        exit;
    }
}
?>
