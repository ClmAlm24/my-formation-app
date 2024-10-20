<?php
session_start();

require '../db_connect.php';
require 'mail.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    $errors = [];
    if (empty($email)) {
        $errors[] = "L'adresse email est requise.";
    }
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user) {
        $errors[] = "Aucun compte n'est associé à cette adresse email.";
    }

    if (empty($errors)) {
        $token = bin2hex(random_bytes(16));
        $expiration = date('Y-m-d H:i:s', strtotime('+3 hour'));

        $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expiration) VALUES (:email, :token, :expiration)");
        $stmt->execute([
            'email' => $email,
            'token' => $token,
            'expiration' => $expiration
        ]);

        $baseLink = "https://zero2hero.emes.bj";
        $resetLink = "$baseLink/reset_password/index.php?token=$token"; 
        $subject = "Réinitialisation de votre mot de passe";
        $message = "Vous avez demandé une réinitialisation de votre mot de passe. Cliquez sur le lien suivant pour réinitialiser votre mot de passe : <a href=\"$resetLink\">$resetLink</a>";
        
        sendResetEmail($email, $subject, $resetLink);

        $_SESSION['success'] = "Un lien de réinitialisation a été envoyé à votre adresse email.";

        header('Location: ./index.php');
        exit;
    } else {
        $_SESSION['errors'] = $errors;

        header('Location: ./index.php');
        exit;
    }
}
?>
