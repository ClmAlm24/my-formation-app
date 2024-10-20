<?php
session_start();

require '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flag = $_POST['flag'];
    $challengeId = $_POST['challenge_id'];
    $userId = $_SESSION['user_id']; 
    $stmt = $pdo->prepare('SELECT c.flag, v.slug FROM challenges c JOIN vulnerabilites v ON c.vuln_id = v.id WHERE c.id = ?');
    $stmt->execute([$challengeId]);
    $challenge = $stmt->fetch();

    if ($challenge) {
        $expectedFlag = $challenge['flag'];
        $slug = $challenge['slug']; 

        if ($flag === $expectedFlag) {
            
            $stmt = $pdo->prepare('SELECT * FROM user_challenges WHERE user_id = ? AND challenge_id = ?');
            $stmt->execute([$userId, $challengeId]);
            $userChallenge = $stmt->fetch();

            if (!$userChallenge) {
                
                $stmt = $pdo->prepare('INSERT INTO user_challenges (user_id, challenge_id) VALUES (?, ?)');
                $stmt->execute([$userId, $challengeId]);

                
                $_SESSION['message'] = [
                    'type' => 'success',
                    'text' => 'Challenge résolu avec succès et ajouté à vos challenges !'
                ];
            } else {
                
                $_SESSION['message'] = [
                    'type' => 'sucess',
                    'text' => 'Ce challenge a déjà été résolu par vous.'
                ];
            }
        } else {
            
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'Erreur : Le flag est incorrect ou le challenge n\'existe pas.'
            ];
        }
    } else {
        
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Erreur : Le challenge n\'existe pas.'
        ];
    }

    
    header("Location: ./index.php?slug=$slug");
    exit();
}
