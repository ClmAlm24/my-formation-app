<?php
// challenge.php

session_start(); // Démarrer la session

require '../db_connect.php'; // Assurez-vous d'inclure votre fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flag = $_POST['flag'];
    $challengeId = $_POST['challenge_id'];

    // Récupérer le challenge avec le slug
    $stmt = $pdo->prepare('SELECT c.flag, v.slug FROM challenges c JOIN vulnerabilites v ON c.vuln_id = v.id WHERE c.id = ?');
    $stmt->execute([$challengeId]);
    $challenge = $stmt->fetch();

    if ($challenge) {
        $expectedFlag = $challenge['flag'];
        $slug = $challenge['slug']; // Récupérer le slug associé au challenge

        // Vérifiez le flag soumis
        if ($flag === $expectedFlag) {
            // Met à jour l'état du challenge à "résolu"
            $stmt = $pdo->prepare('UPDATE challenges SET is_solved = 1 WHERE id = ?');
            $stmt->execute([$challengeId]);

            // Stocker un message de succès dans la session
            $_SESSION['message'] = [
                'type' => 'success',
                'text' => 'Challenge résolu avec succès !'
            ];
        } else {
            // Stocker un message d'erreur dans la session
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'Erreur : Le flag est incorrect ou le challenge n\'existe pas.'
            ];
        }
    } else {
        // Stocker un message d'erreur si le challenge n'existe pas
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Erreur : Le challenge n\'existe pas.'
        ];
    }

    // Redirige vers la page d'accueil avec le slug
    header("Location: ./index.php?slug=$slug");
    exit();
}
