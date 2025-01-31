<?php
    require_once('db.php');
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: mainpage.php");
        exit();
    }
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $investment_id = $_POST['investment_id'];
        $user_id = $_SESSION['user_id'];

        $sql = "SELECT * FROM investment WHERE id = :investment_id AND user_id = :user_id";
        $query = $pdo->prepare($sql);
        $query->execute(['investment_id' => $investment_id, 'user_id' => $user_id]);
        $investment = $query->fetch();
        if ($investment) {
            $deleteQuery = $pdo->prepare("DELETE FROM investment WHERE id = :investment_id AND user_id = :user_id");
            $deleteQuery->execute(['investment_id' => $investment_id, 'user_id' => $user_id]);
    
            $_SESSION['message'] = "Investment wurde erfolgreich gelöscht.";
            header("Location: mainpage.php");
            exit();
        } else {
            $_SESSION['error'] = "Fehler: Investment nicht gefunden oder keine Berechtigung!";
            header("Location: mainpage.php");
            exit();
        }
    }
?>
