<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Wenn eine POST Anfrage gesendet wurde an login.php 
    // WErte die im Login feld eingetragen wurden werden abgerufen
    $username = $_POST['username']; 
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = :username"; // sql abfrage
    $stmt = $pdo->prepare($sql); // sql abfrage an pdo übergeben
    $stmt->execute([':username' => $username]); // Abfrage ausführen und username Wert übergeben
    $user = $stmt->fetch(); // erste Zeile abrufen der Datenbankergebnisse

    if ($user && password_verify($password, $user['password'])) { // wenn user gefunden wurde in db und wenn Passwort übereinstimmt (password_verfy() für hash)
        $_SESSION['username'] = $user['username']; 
        $_SESSION['user_id'] = $user['id']; 
        header("Location: mainpage.php");
        exit();
    } else {
        $error = "Falscher Benutzername/Passwort!";
    }
}
?>
<?php include("navbar.html"); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
<div class="container mt-5">
    <h2>Login</h2>
    <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

    <form method="POST" action="login.php">
        <div class="mb-3">
            <label for="username" class="form-label">Benutzername</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Passwort</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Einloggen</button>
    </form>
    <br><p><a href="index.php">Noch kein Konto erstellt?</a></p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
