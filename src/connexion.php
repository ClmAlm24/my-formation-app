<?php

session_start();


require 'db_connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $errors = [];
    if (empty($email) || empty($password)) {
        $errors[] = "Tous les champs sont requis.";
    }
   
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
        $errors[] = "Email ou mot de passe incorrect.";
    }

    if (empty($errors)) {
        $token = bin2hex(random_bytes(16));
        $expiration = date('Y-m-d H:i:s', strtotime('+3 hour'));
        $stmt = $pdo->prepare("INSERT INTO auth_tokens (user_id, token, expiration) VALUES (:user_id, :token, :expiration)");
        $stmt->execute([
            'user_id' => $user['id'],
            'token' => $token,
            'expiration' => $expiration
        ]);

        $_SESSION['token'] = $token;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['pseudo'] = $user['pseudo']; 
        $_SESSION['success'] = "Connexion réussie !";
        header('Location: ./home/');
        exit;
    } else {
        $_SESSION['errors'] = $errors;
        header('Location: ./index.php');
        exit;
    }
}
?>
