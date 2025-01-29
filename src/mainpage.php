<?php
session_start();

require_once 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT COUNT(*) FROM investment WHERE user_id = ?");
$query->execute([$user_id]);
$investment_count = $query->fetchColumn();



?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Main-Page</title>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary position-sticky top-0">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">INVESTY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto"> 
                <a class="nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</nav>
<br>
<div class="row">
  <div class="col-4">
  <div id="list-example" class="list-group position-sticky" style="top: 80px;">
      <a class="list-group-item list-group-item-action" href="#list-item-1">Investments</a>
      <a class="list-group-item list-group-item-action" href="#list-item-2">Überblick</a>
      <a class="list-group-item list-group-item-action" href="#list-item-3">Live</a>
      <a class="list-group-item list-group-item-action" href="#list-item-4">Item 4</a>
    </div>
  </div>
  <div class="col-8">
    <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" class="scrollspy-example" tabindex="0">
      <h4 id="list-item-1">Investments</h4>
      <?php if ($investment_count <= 0) {
        $noinv= "Keine Investments vorhanden!";
        
        }; 
      ?>
      <p></p>
      <h4 id="list-item-2">Item 2</h4>
      <p><br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf</p>
      <h4 id="list-item-3">Item 3</h4>
      <p><br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf</p>
      <h4 id="list-item-4">Item 4</h4>
      <p><br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf</p>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
