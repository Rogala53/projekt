<?php
include_once 'baSession.php';
?>
<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <title>Bank Accounts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="shortcut icon" href="favico.png" type="image/x-icon">
  <script src="script.js" defer></script>
</head>

<body>
  <div id="message" class="<?= $_SESSION['message_color'] ?>"
    style="display: <?= !empty($_SESSION['message']) ? 'block' : 'none' ?>">
    <?= $_SESSION['message'] ?>
  </div>
  <div id="container">
    <div id="sidebar" class="d-flex flex-column flex-shrink-0 p-3 text-bg-light ">
      <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-black text-decoration-none">
        <span class="fs-4">Bank Accounts</span>
      </a>
      <hr>
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a href="#" class="nav-link active" aria-current="page">
            Accounts
          </a>
        </li>
        <li>
          <a href="history.php" class="nav-link text-black">
            History
          </a>
        </li>
      </ul>
    </div>

    <div id="accounts">
      <div id="account1">
        <img src="./images/PKO.png" alt="PKO" width="100px" height="122px">
        <h2>Balance: <span id="balance1"><?= $_SESSION['account_1_balance'] ?></span> zł</h2>
        <form method="post">
          <input type="hidden" name="form_token" value="<?= $_SESSION['form_token'] ?>">
          <label id="addLabel1" for="addInput1">Deposit</label>
          <input id="addInput1" type="number" name="valueToAdd1" min="0.01" step="0.01">
          <button id="depositButton1" type="submit" name="action" value="deposit1">Add balance</button><br>
          <label id="withdrawLabel1" for="withdrawInput1">Withdraw</label>
          <input id="withdrawInput1" type="number" name="valueToWithdraw1" min="1" step="0.01">
          <button id="withdrawButton1" type="submit" name="action" value="withdraw1">Withdraw</button><br>
          <label id="transferLabel1" for="transferInput1">Transfer</label>
          <input id="transferInput1" type="number" name="valueToTransfer1" min="1" step="0.01">
          <button id="transferButton1" type="submit" name="action" value="transfer1">Transfer</button>
        </form>
      </div>
      <div id="account2">
        <img src="./images/ING.png" alt="ING" width="100px">
        <h2>Balance: <span id="balance2"><?= $_SESSION['account_2_balance'] ?></span> zł</h2>
        <form method="post">
          <input type="hidden" name="form_token" value="<?= $_SESSION['form_token'] ?>">
          <label id="addLabel2" for="addInput2">Deposit</label>
          <input id="addInput2" type="number" name="valueToAdd2" min="0.01" step="0.01">
          <button id="depositButton2" type="submit" name="action" value="deposit2">Add balance</button><br>
          <label id="withdrawLabel2" for="withdrawInput2">Withdraw</label>
          <input id="withdrawInput2" type="number" name="valueToWithdraw2" min="0.01" step="0.01">
          <button id="withdrawButton2" type="submit" name="action" value="withdraw2">Withdraw</button><br>
          <label id="transferLabel2" for="transferInput2">Transfer</label>
          <input id="transferInput2" type="number" name="valueToTransfer2" min="0.01" step="0.01">
          <button id="transferButton2" type="submit" name="action" value="transfer2">Transfer</button>
        </form>
      </div>
    </div>
  </div>
  <footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
      <li class="nav-item"><a href="history.php" class="nav-link px-2 text-body-secondary">History</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
    </ul>
    <p class="text-center text-body-secondary">© 2025 Accounts, Inc</p>
  </footer>
</div>
</body>
<!-- Usunięcie treści wiadomości -->
<?= $_SESSION['message'] = '' ?>

</html>