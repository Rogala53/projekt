<?php
include_once 'baSession.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="history.css">
    <link rel="shortcut icon" href="favico.png" type="image/x-icon">
    <title>History</title>
</head>
<body>
<div id="container">
    <div id="sidebar">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-light " style="width: 280px;">
            <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-black text-decoration-none">
              <span class="fs-4">Bank Accounts</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
              <li class="nav-item">
                <a href="index.php" class="nav-link text-black" aria-current="page">
                  Accounts
                </a>
              </li>
              <li>
                <a href="history.php" class="nav-link active">
                  History
                </a>
              </li>
            </ul>
          </div>
    </div>
        <main>
            <h1>History</h1>
            <ul id="history-list">
                <?php if (!empty($_SESSION['history'])) {
                    foreach ($_SESSION['history'] as $event)
                        echo $event;
                } ?>
            </ul>
            <?php if(empty($_SESSION['history'])) echo "<div>No transactions</div>"; ?>
        </main>  
</div>
<footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="index.php" class="nav-link px-2 text-body-secondary">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">History</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
            </ul>
            <p class="text-center text-body-secondary">© 2025 Accounts, Inc</p>
        </footer>
</body>
</html>