<?php
session_start();

require_once 'db.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
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
<nav class="navbar navbar-expand-lg bg-body-tertiary">
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

<div class="container mt-5">
    <div class="row">
        <div class="col-4" style="position: fixed; top: 80px; bottom: 0; left: 0; width: 25%; padding-right: 0;">
            <nav id="navbar-example3" class="h-100 flex-column align-items-stretch pe-4 border-end" style="height: 100vh; overflow-y: auto;">
                <nav class="nav nav-pills flex-column">
                    <a class="nav-link" href="#item-1">Item 1</a>
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link ms-3 my-1" href="#item-1-1">Item 1-1</a>
                        <a class="nav-link ms-3 my-1" href="#item-1-2">Item 1-2</a>
                    </nav>
                    <a class="nav-link" href="#item-2">Item 2</a>
                    <a class="nav-link" href="#item-3">Item 3</a>
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link ms-3 my-1" href="#item-3-1">Item 3-1</a>
                        <a class="nav-link ms-3 my-1" href="#item-3-2">Item 3-2</a>
                    </nav>
                </nav>
            </nav>
        </div>

        <div class="col-8" style="margin-left: 25%; overflow-y: auto; max-height: 100vh;">
            <div data-bs-spy="scroll" data-bs-target="#navbar-example3" data-bs-smooth-scroll="true" class="scrollspy-example-2" tabindex="0">
                <div id="item-1">
                    <h4>Item 1</h4>
                    <p>Welcome to Item 1! Here we discuss the basics of crypto investments and how to get started.</p>
                </div>
                <div id="item-1-1">
                    <h5>Item 1-1</h5>
                    <p>This section focuses on understanding blockchain technology and its significance in cryptocurrency.</p>
                </div>
                <div id="item-1-2">
                    <h5>Item 1-2</h5>
                    <p>Learn about various types of cryptocurrencies like Bitcoin, Ethereum, and more in this section.</p>
                </div>
                <div id="item-2">
                    <h4>Item 2</h4>
                    <p>Item 2 introduces you <br><br><br><br><br><br><br><br> to investment strategies and risk management techniques for crypto.</p>
                </div>
                <div id="item-3">
                    <h4>Item 3</h4>
                    <p>Here, we cover the tools and platforms you can use to monitor and track your crypto portfolio.</p>
                </div>
                <div id="item-3-1">
                    <h5>Item 3-1</h5>
                    <p>This section goes deeper into the technical aspects of portfolio tracking and portfolio diversification.</p>
                </div>
                <div id="item-3-2">
                    <h5>Item 3-2</h5>
                    <p>Learn about performance metrics and how they can help you evaluate your crypto investments.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
