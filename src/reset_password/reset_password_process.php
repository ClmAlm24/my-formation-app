
<?php
// Démarrage de la session
session_start();

// Inclure le fichier de connexion à la base de données
require '../db_connect.php';

// Vérifier que le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des champs du formulaire
    $password = $_POST['password'];
    $token = $_POST['token'];

    // Vérification des erreurs
    $errors = [];
    if (empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    }

    // Vérifier la validité du token
    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = :token AND expiration > NOW()");
    $stmt->execute(['token' => $token]);
    $resetRequest = $stmt->fetch();

    if (!$resetRequest) {
        $errors[] = "Lien de réinitialisation invalide ou expiré.";
    }

    // Si pas d'erreurs, mettre à jour le mot de passe
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Mettre à jour le mot de passe dans la base de données
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
        $stmt->execute([
            'password' => $hashedPassword,
            'email' => $resetRequest['email']
        ]);

        // Supprimer le token de réinitialisation
        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE token = :token");
        $stmt->execute(['token' => $token]);

        // Stocker un message de succès dans la session
        $_SESSION['success'] = "Votre mot de passe a été réinitialisé avec succès.";

        // Redirection vers la page de connexion
        header('Location: ../');
        exit;
    } else {
        // Si des erreurs sont présentes, les stocker dans la session
        $_SESSION['errors'] = $errors;

        // Redirection vers le formulaire de réinitialisation avec les erreurs
        header('Location: ./index.php?token=' . htmlspecialchars($token));
        exit;
    }
}
