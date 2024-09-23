<?php
session_start();
require '../db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vuln_id = $_POST['vuln_id'];
    $is_finished = $_POST['is_finished'];
    // Mettre à jour la base de données
    $stmt = $pdo->prepare('UPDATE cours SET is_finished = :is_finished WHERE vuln_id = :vuln_id');
    $stmt->execute(['is_finished' => $is_finished, 'vuln_id' => $vuln_id]);
    if ($is_finished == 1) {
        // Mettre à jour la progression
        $stmt = $pdo->prepare('UPDATE progression SET cours_termine = 1 WHERE vuln_id = :vuln_id AND user_id = :user_id');
        $stmt->execute(['vuln_id' => $vuln_id, 'user_id' => $_SESSION['user_id']]);
    }
    // Redirection avec un message
    $_SESSION['message'] = [
        'type' => 'success',
        'text' => 'Statut du cours mis à jour avec succès.',
    ];

    if ($stmt->rowCount() > 0) {
        echo 'Statut du cours mis à jour avec succès.';
    } else {
        echo 'Aucune mise à jour effectuée. Vérifiez si le statut est déjà identique.';
    }
    header('Location: index.php?slug=sqli');
    exit;
}
?>
