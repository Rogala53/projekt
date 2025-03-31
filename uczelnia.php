<?php
session_start();
if (!isset($_SESSION['account_1_balance'])) {
    $_SESSION['account_1_balance'] = 0;
    $_SESSION['account_2_balance'] = 0;
    $_SESSION['form_token'] = bin2hex(random_bytes(16));
    $_SESSION['message_color'] = '';
    $_SESSION['message'] = '';
    $_SESSION['history'] = [];
}

// funkcje do obsługi transakcji

function addBalance($account, $valueToAdd): mixed
{
    if ($valueToAdd === '')
        return $account;
    $account += $valueToAdd;
    $_SESSION['message_color'] = 'green';
    $_SESSION['message'] = 'Adding balance successful';
    if ($_POST['action'] === 'deposit1') {
        array_unshift($_SESSION['history'], "<li class='green'><img src='./images/deposit-green.png' width='22px' height='22px'>" . $valueToAdd . " zlotych has been added to IKO account.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
    } else {
        array_unshift($_SESSION['history'], "<li class='green'><img src='./images/deposit-green.png' width='22px' height='22px'>" . $valueToAdd . " zlotych has been added to ING account.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
    }
    return $account;
}

function withdraw($account, $valueToWithdraw)
{
    if ($valueToWithdraw === '')
        return $account;
    if ($account < $valueToWithdraw) {
        $_SESSION['message_color'] = 'red';
        $_SESSION['message'] = 'You don\'t have enough money to withdraw';
        if ($_POST['action'] === 'withdraw1') {
            array_unshift($_SESSION['history'], "<li class='red'><img src='./images/withdraw-red.png' width='20px' height='20px'>Withdraw of " . $valueToWithdraw . " zlotych from IKO account has been canceled.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
        } else {
            array_unshift($_SESSION['history'], "<li class='red'><img src='./images/withdraw-red.png' width='20px' height='20px'>Withdraw of " . $valueToWithdraw . " zlotych from ING account has been canceled.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
        }

    } else {
        $account -= $valueToWithdraw;
        $_SESSION['message_color'] = 'green';
        $_SESSION['message'] = 'Withdraw successful';
        if ($_POST['action'] === 'withdraw1') {
            array_unshift($_SESSION['history'], "<li class='green'><img src='./images/withdraw-green.png' width='20px' height='20px'>Withdraw of " . $valueToWithdraw . " zlotych from IKO account has been made.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
        } else {
            array_unshift($_SESSION['history'], "<li class='green'><img src='./images/withdraw-green.png' width='20px' height='20px'>Withdraw of " . $valueToWithdraw . " zlotych from ING account has been made.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
        }
    }
    return $account;
}

function transfer($accountFrom, $valueToTransfer, $accountTo)
{
    if ($valueToTransfer === '')
        return array($accountFrom, $accountTo);
    if ($accountFrom < $valueToTransfer) {
        $_SESSION['message_color'] = 'red';
        $_SESSION['message'] = 'You don\'t have enough money to transfer';
        if ($_POST['action'] === 'transfer1') {
            array_unshift($_SESSION['history'], "<li class='red'><img src='./images/transfer-red.png' width='20px' height='20px'>Transfer of " . $valueToTransfer . " zlotych from IKO to ING account has been canceled.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
        } else {
            array_unshift($_SESSION['history'], "<li class='red'><img src='./images/transfer-red.png' width='20px' height='20px'>Transfer of " . $valueToTransfer . " zlotych from ING to IKO account has been canceled.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
        }
    } else {
        $accountFrom -= $valueToTransfer;
        $accountTo += $valueToTransfer;
        $_SESSION['message_color'] = 'green';
        $_SESSION['message'] = 'Transfer successful';
        if ($_POST['action'] === 'transfer1') {
            array_unshift($_SESSION['history'], "<li class='green'><img src='./images/transfer-green.png' width='20px' height='20px'>Transfer of " . $valueToTransfer . " zlotych from IKO to ING account has been made.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
        } else {
            array_unshift($_SESSION['history'], "<li class='green'><img src='./images/transfer-green.png' width='20px' height='20px'>Transfer of " . $valueToTransfer . " zlotych from ING to IKO account has been made.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
        }
    }
    return array($accountFrom, $accountTo);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['form_token'] === $_SESSION['form_token']) {
        switch ($_POST['action']) {
            case 'deposit1':
                $_SESSION['account_1_balance'] = addBalance($_SESSION['account_1_balance'], $_POST['valueToAdd1']);
                break;
            case 'withdraw1':
                $_SESSION['account_1_balance'] = withdraw($_SESSION['account_1_balance'], $_POST['valueToWithdraw1']);
                break;
            case 'transfer1':
                list($_SESSION['account_1_balance'], $_SESSION['account_2_balance']) = transfer($_SESSION['account_1_balance'], $_POST['valueToTransfer1'], $_SESSION['account_2_balance']);
                break;
            case 'deposit2':
                $_SESSION['account_2_balance'] = addBalance($_SESSION['account_2_balance'], $_POST['valueToAdd2']);
                break;
            case 'withdraw2':
                $_SESSION['account_2_balance'] = withdraw($_SESSION['account_2_balance'], $_POST['valueToWithdraw2']);
                break;
            case 'transfer2':
                list($_SESSION['account_2_balance'], $_SESSION['account_1_balance']) = transfer($_SESSION['account_2_balance'], $_POST['valueToTransfer2'], $_SESSION['account_1_balance']);
                break;
        }
        //Generowanie nowego tokenu
        $_SESSION['form_token'] = bin2hex(random_bytes(16));
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Bank Accounts</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favico.png" type="image/x-icon">
    <script src="script.js"></script>
</head>
<body>
    <div id="container">
        <div id="message" class="<?= $_SESSION['message_color'] ?>"
            style="display: <?= !empty($_SESSION['message']) ? 'block' : 'none' ?>">
            <?= $_SESSION['message'] ?>
        </div>
        <div id="accounts">
            <div id="account1">
                <img src="./images/PKO.png" alt="PKO" width="100px" height="122px">
                <h2>Balance: <?= $_SESSION['account_1_balance'] ?> zł</h2>
                <form method="post">
                    <input type="hidden" name="form_token" value="<?= $_SESSION['form_token'] ?>">
                    <input id="addInput1" type="number" name="valueToAdd1" min="0.01" step="0.01" placeholder="Deposit">
                    <button id="depositButton1" type="submit" name="action" value="deposit1">Add balance</button>
                    <input id="withdrawInput1" type="number" name="valueToWithdraw1" min="1" step="0.01"
                        placeholder="Withdraw">
                    <button id="withdrawButton1" type="submit" name="action" value="withdraw1">Withdraw</button>
                    <input id="transferInput1" type="number" name="valueToTransfer1" min="1" step="0.01"
                        placeholder="Transfer">
                    <button id="transferButton1" type="submit" name="action" value="transfer1">Transfer</button>
                </form>
            </div>
            <div id="account2">
                <img src="./images/ING.png" alt="ING" width="100px">
                <h2>Balance: <?= $_SESSION['account_2_balance'] ?> zł</h2>
                <form method="post">
                    <input type="hidden" name="form_token" value="<?= $_SESSION['form_token'] ?>">
                    <input id="addInput2" type="number" name="valueToAdd2" min="0.01" step="0.01" placeholder="Deposit">
                    <button id="depositButton2" type="submit" name="action" value="deposit2">Add balance</button>
                    <input id="withdrawInput2" type="number" name="valueToWithdraw2" min="0.01" step="0.01"
                        placeholder="Withdraw">
                    <button id="withdrawButton2" type="submit" name="action" value="withdraw2">Withdraw</button>
                    <input id="transferInput2" type="number" name="valueToTransfer2" min="0.01" step="0.01"
                        placeholder="Transfer">
                    <button id="transferButton2" type="submit" name="action" value="transfer2">Transfer</button>
                </form>
            </div>
        </div>
        <details>
            <summary>History</summary>
            <ul id="history-list">
                <?php if (!empty($_SESSION['history'])) {
                    foreach ($_SESSION['history'] as $event)
                        echo $event;
                } else
                    echo '<div>No transactions</div>'; ?>
            </ul>
        </details>
    </div>
</body>
<!-- Usunięcie treści wiadomości -->
<?= $_SESSION['message'] = '' ?>
</html>