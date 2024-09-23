<?php
// Démarrage de la session
session_start();

// Vérification de la connexion de l'utilisateur
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, renvoyer une erreur
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

// Inclusion du fichier de connexion à la base de données
require_once '../db_connect.php';

// Récupération des informations de l'utilisateur
$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT email, pseudo, created_at FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupération des cours terminés
$stmt = $pdo->prepare("
    SELECT v.nom, c.titre
    FROM progression p
    JOIN vulnerabilites v ON p.vuln_id = v.id
    JOIN cours c ON v.id = c.vuln_id
    WHERE p.user_id = ? AND p.cours_termine = 1
");
$stmt->execute([$userId]);
$completedCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des challenges réussis par l'utilisateur
$stmt = $pdo->prepare("
    SELECT v.nom, ch.description
    FROM challenges ch
    JOIN vulnerabilites v ON ch.vuln_id = v.id
    JOIN progression p ON p.vuln_id = ch.vuln_id
    WHERE p.user_id = ? AND ch.is_solved = 1
");
$stmt->execute([$userId]);
$completedChallenges = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcul des scores des cours et des challenges
$stmt = $pdo->prepare("
    SELECT 
        COUNT(CASE WHEN cours_termine = 1 THEN 1 END) as completed_courses
    FROM progression
    WHERE user_id = ?
");
$stmt->execute([$userId]);
$completedCoursesCount = $stmt->fetchColumn();

// Compter le nombre total de challenges réussis
$stmt = $pdo->prepare("
    SELECT COUNT(*) as completed_challenges
    FROM challenges ch
    WHERE ch.is_solved = 1 AND ch.vuln_id = ?
");
$stmt->execute([$userId]);
$completedChallengesCount = $stmt->fetchColumn();

// Compter le nombre total de cours
$stmt = $pdo->prepare("SELECT COUNT(*) as total_courses FROM cours");
$stmt->execute();
$totalCourses = $stmt->fetchColumn();

// Compter le nombre total de challenges
$stmt = $pdo->prepare("SELECT COUNT(*) as total_challenges FROM challenges");
$stmt->execute();
$totalChallenges = $stmt->fetchColumn();

// Calculer le taux de complétion des cours
$courseCompletionRate = ($totalCourses > 0) 
    ? ($completedCoursesCount / $totalCourses) * 100 
    : 0;

// Calculer le taux de réussite des challenges
$challengeCompletionRate = ($totalChallenges > 0) 
    ? ($completedChallengesCount / $totalChallenges) * 100 
    : 0;

// Récupération des vulnérabilités disponibles
$stmt = $pdo->prepare("SELECT nom FROM vulnerabilites");
$stmt->execute();
$vulnerabilities = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Préparation des données pour l'affichage
$userData = [
    'pseudo' => $user['pseudo'],
    'email' => $user['email'],
    'dateInscription' => date('d/m/Y', strtotime($user['created_at'])),
    'scores' => [
        'Taux de complétion des cours' => round($courseCompletionRate, 2) . '%',
        'Taux de réussite des challenges' => round($challengeCompletionRate, 2) . '%',
        'Cours terminés' => $completedCoursesCount,
        'Challenges réussis' => $completedChallengesCount
    ],
    'completedCourses' => $completedCourses,
    'completedChallenges' => $completedChallenges,
    'availableVulnerabilities' => $vulnerabilities
];

// Envoi des données au format JSON
header('Content-Type: application/json');
echo json_encode($userData);
?>
