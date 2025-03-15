<?php
session_start();

if (!isset($_SESSION['account_1_balance'])) {
    $_SESSION['account_1_balance'] = 0;
    $_SESSION['account_2_balance'] = 0;
}

function addBalance(&$currentBalance, $valueToAdd) {
    $currentBalance += $valueToAdd;
}


function withdraw(&$currentBalance, $valueToWithdraw) {
    if ($currentBalance < $valueToWithdraw) {
        echo "<script>alert('You don't have enough money to withdraw')</script>";
    } else {
        $currentBalance -= $valueToWithdraw;
    }
}

function transfer(&$accountFrom, $valueToTransfer, &$accountTo) {
    if ($accountFrom < $valueToTransfer) {
        echo "<script>alert('You don't have enough money to transfer')</script>";
    } else {
        $accountFrom -= $valueToTransfer;
        $accountTo += $valueToTransfer;
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'deposit1':
                addBalance($_SESSION['account_1_balance'], $_POST['valueToAdd1']);
                break;
            case 'withdraw1':
                withdraw($_SESSION['account_1_balance'], $_POST['valueToWithdraw1']);
                break;
            case 'transfer1':
                transfer($_SESSION['account_1_balance'], $_POST['valueToTransfer1'], $_SESSION['account_2_balance']);
                break;
            case 'deposit2':
                addBalance($_SESSION['account_2_balance'], $_POST['valueToAdd2']);
                break;
            case 'withdraw2':
                withdraw($_SESSION['account_2_balance'], $_POST['valueToWithdraw2']);
                break;
            case 'transfer2':
                transfer($_SESSION['account_2_balance'], $_POST['valueToTransfer2'], $_SESSION['account_1_balance']);
                break;
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Bank Account</title>
</head>
<body>
    <div id="container">
        <div id="account1">
            <h2>Stan konta: <?= $_SESSION['account_1_balance'] ?> zł</h2>
            <form method="post">
                <input type="number" name="valueToAdd1" min="1" value="valueToAdd1">
                <button type="submit" name="action" value="deposit1">Wpłać na konto</button>
                <input type="number" name="valueToWithdraw1" min="0" value="valueToWithdraw1">
                <button type="submit" name="action" value="withdraw1">Wypłać z konta</button>
                <input type="number" name="valueToTransfer1"min="1" value="valueToTransfer1">
                <button type="submit" name="action" value="transfer1">Przelew</button>
            </form>
        </div>
        <div id="account2">
            <h2>Stan konta: <?= $_SESSION['account_2_balance'] ?> zł</h2>
            <form method="post">
                <input type="number" name="valueToAdd2" min="1" value="valueToAdd2">
                <button type="submit" name="action" value="deposit2">Wpłać na konto</button>
                <input type="number" name="valueToWithdraw2" min="0" value="valueToWithdraw2">
                <button type="submit" name="action" value="withdraw2">Wypłać z konta</button>
                <input type="number" name="valueToTransfer2" min="1" value="valueToTransfer2">
                <button type="submit" name="action" value="transfer2">Przelew</button>
            </form>
        </div>
    </div>
</body>
</html>
<style>
    * {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    #container {
        display: flex;
        justify-content: space-around;
        margin-top: 50px;
    }
    #account1, #account2 {
        padding: 20px;
        width: 300px;
        text-align: center;    
    }
    h2 {
        font-size: 32px;
        text-align: center;
    }
    form {
        margin-top: 20px;
    }
    form > * {
        margin: 10px;
        padding: 15px;
    }
    form > input {
        border: 1px solid black;
        font-size: 16px;
    }
    button {
        color: white;
        cursor: pointer;
        background-color:rgba(10, 0, 120, 0.73);
        border: none;
        border-radius:10px;
    }
    button:hover {
        background-color: rgb(0, 0, 120);
    }
</style>