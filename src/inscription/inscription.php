<?php

session_start();


require '../db_connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pseudo = trim($_POST['pseudo']);
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];

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

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR pseudo = :pseudo");
    $stmt->execute(['email' => $email, 'pseudo' => $pseudo]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $_SESSION['error'] = "L'email ou le pseudo sont déjà utilisés.";
        header('Location: ./index.php');
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (email, pseudo, password) VALUES (:email, :pseudo, :password)");
    $stmt->execute([
        'email' => $email,
        'pseudo' => $pseudo,
        'password' => $hashedPassword
    ]);

    
    $_SESSION['success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
    header('Location: ../');
    exit;
}
?>
