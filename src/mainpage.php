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

$query = $pdo ->prepare("SELECT * FROM investment WHERE user_id = :user_id");
$query->execute([':user_id' => $user_id]);
$investments = $query->fetchAll();


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
    <?php if ($investment_count <= 0): ?> 
        <p>Keine Investments vorhanden!</p><br>
        <p>Füge mehrere Investments hinzu, um einen Überblick zu erhalten:</p><br>
    
    <?php else: ?>
        <div class="container">
        <div class="row">
            <?php foreach ($investments as $investment): ?>
                <div class="col-md-3 mb-3"> 
                    <div class="card text-white bg-light p-2">
                        <form method="POST" action="deleteinvestment.php">
                            <input type="hidden" name="investment_id" value="<?php echo $investment['id']; ?>">
                            <button type="submit" class="btn btn-outline-danger">Entfernen</button>
                        </form>
                        <p class="text-center text-dark">
                            <?php echo htmlspecialchars($investment['investment_type']); ?><br>
                            <?php echo number_format($investment['amount'], 2, ',', '.'); ?> €<br>
                            <?php echo date('d.m.Y', strtotime($investment['investment_date'])); ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        </div>
    <?php endif; ?>
    <br><br>  
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Investment hinzufügen
    </button>
    <br><br>
    <?php if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']); 
    }
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']); 
    }
    ?>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Füge deine Investments hinzu</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form method="POST" action="investment.php">
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Welches Investment</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" name="investment_type" placeholder="Bitcoin, Solana, Ethereum, Gold,... " required>
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Betrag in €</label>
                    <input type="number" step="0.01" class="form-control" min="0.01" step="0.01" id="formGroupExampleInput2" name="amount" placeholder="100.12" required>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>
      <h4 id="list-item-2"><br>Überblick</h4>
      <p><br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf</p>
      <h4 id="list-item-3">Live</h4>
      <p><br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf</p>
      <h4 id="list-item-4">Test</h4>
      <p><br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf</p>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
