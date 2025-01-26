<?php
session_start();
require 'index.php';  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['name'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = :name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['username'];
        header('Location: dashboard.php');
        exit();
    } else {
        $error_message = "Ungültiger Benutzername oder Passwort.";
    }
}
?>
