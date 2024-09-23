<?php
// Démarrage de la session
session_start();

// Inclure le fichier de connexion à la base de données
require '../db_connect.php';
require 'mail.php'; // Inclure votre script d'envoi d'email

// Vérification que le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et validation des champs du formulaire
    $email = trim($_POST['email']);

    // Vérification des erreurs
    $errors = [];
    if (empty($email)) {
        $errors[] = "L'adresse email est requise.";
    }

    // Vérification si l'email existe dans la base de données
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user) {
        $errors[] = "Aucun compte n'est associé à cette adresse email.";
    }

    // Si pas d'erreurs, générer le token de réinitialisation
    if (empty($errors)) {
        $token = bin2hex(random_bytes(16));
        $expiration = date('Y-m-d H:i:s', strtotime('+3 hour'));

        // Insertion du token dans la base de données
        $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expiration) VALUES (:email, :token, :expiration)");
        $stmt->execute([
            'email' => $email,
            'token' => $token,
            'expiration' => $expiration
        ]);

        // Envoi de l'email avec le lien de réinitialisation
        $resetLink = "http://localhost/my-formation-app/src/reset_password/index.php?token=$token"; // Remplacez par l'URL correcte
        $subject = "Réinitialisation de votre mot de passe";
        $message = "Vous avez demandé une réinitialisation de votre mot de passe. Cliquez sur le lien suivant pour réinitialiser votre mot de passe : <a href=\"$resetLink\">$resetLink</a>";
        
        // Utilisation de PHPMailer pour envoyer l'email
        sendResetEmail($email, $subject, $resetLink);

        // Stocker un message de succès dans la session
        $_SESSION['success'] = "Un lien de réinitialisation a été envoyé à votre adresse email.";

        // Redirection vers le formulaire de réinitialisation
        header('Location: ./index.php');
        exit;
    } else {
        // Si des erreurs sont présentes, les stocker dans la session
        $_SESSION['errors'] = $errors;

        // Redirection vers le formulaire de réinitialisation avec les erreurs
        header('Location: ./index.php');
        exit;
    }
}
?>
