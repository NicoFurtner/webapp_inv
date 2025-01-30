<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $investment_type = $_POST['investment_type'];
    $amount = $_POST['amount'];
    $user_id = $_SESSION['user_id']; 
    $investment_date = date('Y-m-d'); 

    $sql = "INSERT INTO investment (user_id, investment_type, amount, investment_date) 
            VALUES (:user_id, :investment_type, :amount, :investment_date)";
    
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([
        ':user_id' => $user_id,
        ':investment_type' => $investment_type,
        ':amount' => $amount,
        ':investment_date' => $investment_date
    ])) {
        header("Location: mainpage.php");
        exit();
    } else {
        echo "Fehler beim Hinzufügen des Investments!";
    }
}
?>