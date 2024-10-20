<?php
require_once '../db_connect.php';

function updatePassword($userId, $currentPassword, $newPassword) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if ($user && password_verify($currentPassword, $user['password'])) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $updateStmt->execute([$hashedPassword, $userId]);
    }
    return false;
}

function updateEmail($userId, $newEmail, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        
        $checkEmailStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND id != ?");
        $checkEmailStmt->execute([$newEmail, $userId]);
        if ($checkEmailStmt->fetchColumn() > 0) {
            return 'email_exists';
        }

        $updateStmt = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
        return $updateStmt->execute([$newEmail, $userId]) ? true : false;
    }
    return false;
}

function updateUsername($userId, $newUsername, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {

        $checkUsernameStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE pseudo = ? AND id != ?");
        $checkUsernameStmt->execute([$newUsername, $userId]);
        if ($checkUsernameStmt->fetchColumn() > 0) {
            return 'username_exists';
        }

        $updateStmt = $pdo->prepare("UPDATE users SET pseudo = ? WHERE id = ?");
        return $updateStmt->execute([$newUsername, $userId]) ? true : false;
    }
    return false;
}