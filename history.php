<?php
include_once 'backend/session.php';
include_once 'backend/Db_handler.php';
$db_handler = new Db_handler('localhost', 'root', '', 'prog_aplik');
$db_handler->connect();
$conn = $db_handler->get_connection();
include_once 'backend/Transactions_handler.php';
$tr_handler = new Transactions_handler();
$tr_handler->set_history_list($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="history.css">
  <link rel="shortcut icon" href="favico.png" type="image/x-icon">
  <script src="jquery-x.x.min.js" defer></script>
  <script src="darkMode.js" defer></script>
  <title>History</title>
</head>

<body>
  <div class="container">
      <div class="sidebar d-flex flex-column flex-shrink-0 p-3 ">
        <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-black text-decoration-none">
          <span class="fs-4">Bank Accounts</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
          <li class="nav-item">
            <a href="index.php" class="nav-link " aria-current="page">
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
    <img src="./images/dark-mode.png" alt="darkmode" id="dark-mode-button">
    <main>
      <h1>History</h1>
      <ul class="history-list">
        <?php
            $history = $tr_handler->get_history();
            if(empty($history)) {
              echo "<div class='no-transactions'>No transactions</div>";
            } else {
              foreach ($history as $event) {
              if ($event['status']) {
                $status = 'success';
              } else {
                $status = 'failure';
              }
              $message = $event['message'];
              $date = $event['date'];
              echo "<li class='history-item $status'>$message<span>$date</span></li>";
              }
            }
             ?>
      </ul>
    </main>
  <footer class="py-3 my-4">
    <ul class="nav justify-content-center pb-3 mb-3 ">
      <li class="nav-item"><a href="index.php" class="px-2 ">Accounts</a></li>
      <li class="nav-item"><a href="#" class="px-2 ">History</a></li>
    </ul>
    <p class="text-center ">© 2025 Accounts, Inc</p>
  </footer>
</body>

</html>


