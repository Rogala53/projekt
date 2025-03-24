<?php
session_start();

if (!isset($_SESSION['account_1_balance'])) {
    $_SESSION['account_1_balance'] = 0;
    $_SESSION['account_2_balance'] = 0;
    $_SESSION['form_token'] = bin2hex(random_bytes(32));
}

function addBalance($account, $valueToAdd) {
    $account += $valueToAdd;
    $_SESSION['message_color'] = 'green';
    $_SESSION['message'] = 'Adding balance successful';
    return $account;
}

function withdraw($account, $valueToWithdraw) {
    if($valueToWithdraw == null) return;
    if($account < $valueToWithdraw) {
        $_SESSION['message_color'] = 'red';
        $_SESSION['message'] = 'You don\'t have enough money to withdraw';
    } else {
        $account -= $valueToWithdraw;
        $_SESSION['message_color'] = 'green';
        $_SESSION['message'] = 'Withdraw successful';
    }
    return $account;
}

function transfer($accountFrom, $valueToTransfer, $accountTo) {
    if($valueToTransfer == null) return;
    if ($accountFrom < $valueToTransfer) {
        $_SESSION['message_color'] = 'red';
        $_SESSION['message'] = 'You don\'t have enough money to transfer';
    } else {
        $accountFrom -= $valueToTransfer;
        $accountTo += $valueToTransfer;
        $_SESSION['message_color'] = 'green';
        $_SESSION['message'] = 'Transfer successful';
    }
    return array($accountFrom, $accountTo);
}


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['form_token'] === $_SESSION['form_token']) {
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
        $_SESSION['form_token'] = bin2hex(random_bytes(32));
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
</head>
<body>
    <div id="container">
        <div id="message" class="<?= $_SESSION['message_color']?>" style="display: <?= !empty($_SESSION['message']) ? 'block' : 'none'?>">
            <?= $_SESSION['message'] ?>
        </div>
        <div id="account1">
            <img src="./images/PKO.png" alt="PKO" width="100px" height="122px">
            <h2>Balance: <?= $_SESSION['account_1_balance'] ?> zł</h2>
            <form method="post">
                <input type="hidden" name="form_token" value="<?= $_SESSION['form_token'] ?>">
                <input type="number" name="valueToAdd1" min="1" step="0.01">
                <button type="submit" name="action" value="deposit1">Add balance</button>
                <input type="number" name="valueToWithdraw1" min="1" step="0.01">
                <button type="submit" name="action" value="withdraw1">Withdraw</button>
                <input type="number" name="valueToTransfer1"min="1" step="0.01">               
                <button type="submit" name="action" value="transfer1">Transfer</button>
            </form>
        </div>
        <div id="account2">
            <img src="./images/ING.png" alt="ING" width="100px">
            <h2>Balance: <?= $_SESSION['account_2_balance'] ?> zł</h2>
            <form method="post">
                <input type="hidden" name="form_token" value="<?= $_SESSION['form_token'] ?>">
                <input type="number" name="valueToAdd2"min="1" step="0.01">
                <button type="submit" name="action" value="deposit2">Add balance</button>
                <input type="number" name="valueToWithdraw2" min="1" step="0.01">
                <button type="submit" name="action" value="withdraw2">Withdraw</button>
                <input type="number" name="valueToTransfer2"min="1" step="0.01">               
                <button type="submit" name="action" value="transfer2">Transfer</button>
            </form>
        </div>
    </div>
</body>
<?= $_SESSION['message'] = ''?>
</html>