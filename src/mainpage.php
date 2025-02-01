<?php
session_start();

require_once 'db.php';

// Überprüfen ob ein username gesetzt ist (also ein Benutzer eingeloggt ist) --> wenn nicht dann zurück zu login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Benutzer id speichern um investment tabelle abzufragen
$user_id = $_SESSION['user_id'];

// Investment Tabelle abfragen --> Anzahl der investments
$query = $pdo->prepare("SELECT COUNT(*) FROM investment WHERE user_id = ?");
$query->execute([$user_id]); // sql Abrfage ausführen
$investment_count = $query->fetchColumn(); // erste Spalte des Ergebnisses zurückgeben (Anzahl des investments)

// Die Details abfragen der investment Tabelle 
$query = $pdo ->prepare("SELECT * FROM investment WHERE user_id = :user_id");
$query->execute([':user_id' => $user_id]); // sql Abfrage ausführen
$investments = $query->fetchAll(); // Zeilen als Array speichern, dann kann man alles Abfragen später mit z.B. $investment['amount']


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
<!-- navbar aus bootstrap-->
<nav class="navbar navbar-expand-lg bg-body-tertiary position-sticky top-0">
    <div class="container-fluid">
        <a class="navbar-brand" href="logout.php">INVESTY</a>
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
<!-- links "navbar" zum scrollen -->
<div class="row">
  <div class="col-4">
  <div id="list-example" class="list-group position-sticky" style="top: 80px;">
      <a class="list-group-item list-group-item-action" href="#list-item-1">Investments</a>
      <a class="list-group-item list-group-item-action" href="#list-item-2">Überblick</a>
      <a class="list-group-item list-group-item-action" href="#list-item-3">Live</a>
      <a class="list-group-item list-group-item-action" href="#list-item-4">In Arbeit</a>
    </div>
  </div>
  <div class="col-8">
    <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" class="scrollspy-example" tabindex="0">
    <h4 id="list-item-1">Investments</h4>
    <?php if ($investment_count <= 0): ?> 
        <p>Keine Investments vorhanden!</p>
        <p>Füge mehrere Investments hinzu, um einen Überblick zu erhalten:</p><br>
    
    <?php else: ?>
        <div class="container">
        <div class="row">
            <?php foreach ($investments as $investment): ?> <!-- Iteriert über jedes Element des Arrays invstment -->
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
    <?php 
    if (isset($_SESSION['message'])) { // Ausgabe aus deleteinvestment.php (wenn investment löschen erfolgreich war oder nicht)
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
    <?php 
    if ($investment_count <= 0) {
        echo "Keine Investments vorhanden!";
    }
    /*
        In else gebe ich mir den Kurs aus vom aktuellen investment_type des users
        Damit ich es verstehe mehr, jede Zeile Dokumentiert
    */
    else {
        $investment_type = strtolower($investment['investment_type']); // Wert des investment_type in Kleinbuchstabten
        $currency = 'eur'; 

        $api_url = 'https://api.coingecko.com/api/v3/simple/price?ids=' . $investment_type . '&vs_currencies=eur'; 
        // Erstellt die URL für API-Anfrage an "CoinCecko", ids= ist dabei der Parameter, mit dem ich dann die Kryptowähr. angebe, &vs_currencies=eur gibt an, dass ich es mit EUR anzeigen möchte. 

        $response = file_get_contents($api_url); // HTTP Anfrage wird gespeichert als String (enthält JSON Antwort von CoinGecko)

        if ($response !== FALSE) { // Überprüfen, ob API-Anfrage erfolgreich war.
            $data = json_decode($response, true); // Hier wird die JSON ausgabe umgewandelt in PHP Array (zweiter Param true = Array)
            if (isset($data[$investment_type][$currency])) { // Schaut ob Währungstyp investment_type und currency in $data vorhanden ist
                $crypto_price = $data[$investment_type][$currency]; // falls ja, speichert den Kurs
                echo "<br><b>Aktueller Kurs von " . ucfirst($investment_type) . ":</b> €" . number_format($crypto_price, 2, ',', '.') . " EUR";
            } else {
                echo "<br><b>Kurs nicht verfügbar</b>";
            }
        } else {
            echo "<br><b>Fehler beim Abrufen des Kurses</b>";
        }
    }

        ?>


       
    
      <p><br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf</p>
      <h4 id="list-item-3">Live</h4>
      <p><br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf</p>
      <h4 id="list-item-4">In Arbeit</h4>
      <p><br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf<br><br><br><br><br><br><br><br><br><br>asdf</p>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>