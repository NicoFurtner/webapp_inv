<?php
session_start();
require 'index.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['name'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = :name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $username]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        $error_message = "Benutzername bereits vergeben.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute(['username' => $username, 'password' => $hashedPassword]);
            header('Location: login.php');
            exit();
        } catch (PDOException $e) {
            echo "Fehler: " . $e->getMessage();
        }
    }
}
?>
