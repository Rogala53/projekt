<?php
session_start();

if (!isset($_SESSION['account_1_balance'])) {
    $_SESSION['account_1_balance'] = 0;
    $_SESSION['account_2_balance'] = 0;
}

function addBalance(&$currentBalance, $valueToAdd) {
    if($valueToAdd == null) return;
    $currentBalance += $valueToAdd;
    $_SESSION['error_message'] = '';
}


function withdraw(&$currentBalance, $valueToWithdraw) {
    if($valueToWithdraw == null) return;
    if ($currentBalance < $valueToWithdraw) {
        $_SESSION['error_message'] = 'You don\'t have enough money to withdraw';
    } else {
        $currentBalance -= $valueToWithdraw;
        $_SESSION['error_message'] = '';
    }
}

function transfer(&$accountFrom, $valueToTransfer, &$accountTo) {
    if($valueToTransfer == null) return;
    if ($accountFrom < $valueToTransfer) {
        $_SESSION['error_message'] = 'You don\'t have enough money to transfer';
    } else {
        $accountFrom -= $valueToTransfer;
        $accountTo += $valueToTransfer;
        $_SESSION['error_message'] = '';
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
        <div id="error" style="display: <?= !empty($_SESSION['error_message']) ? 'block' : 'none' ?>">
            <?= $_SESSION['error_message'] ?>
    </div>
        <div id="account1">
            <h2>Stan konta: <?= $_SESSION['account_1_balance'] ?> zł</h2>
            <form method="post">
                <input type="number" name="valueToAdd1" min="1" step="0.01" value="valueToAdd1">
                <button type="submit" name="action" value="deposit1">Wpłać na konto</button>
                <input type="number" name="valueToWithdraw1" min="0" step="0.01" value="valueToWithdraw1">
                <button type="submit" name="action" value="withdraw1">Wypłać z konta</button>
                <input type="number" name="valueToTransfer1"min="1" step="0.01" value="valueToTransfer1">
                <button type="submit" name="action" value="transfer1">Przelew</button>
            </form>
        </div>
        <div id="account2">
            <h2>Stan konta: <?= $_SESSION['account_2_balance'] ?> zł</h2>
            <form method="post">
                <input type="number" name="valueToAdd2" min="1" step="0.01" value="valueToAdd2">
                <button type="submit" name="action" value="deposit2">Wpłać na konto</button>
                <input type="number" name="valueToWithdraw2" min="1" step="0.01" value="valueToWithdraw2">
                <button type="submit" name="action" value="withdraw2">Wypłać z konta</button>
                <input type="number" name="valueToTransfer2" min="1" step="0.01" value="valueToTransfer2">
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
    #error {
        color: rgb(200, 32, 32);
        background-color: rgb(243, 243, 243);
        border: 2px solid rgb(200, 32, 32);
        padding: 20px;
        text-align: center;
        font-weight: bolder;
        position: absolute;
        font-size: 16px;
        top: 10px;
        animation: slide 0.5s ease-out forwards, transparency 4s ease-out 1s forwards;
        border-radius: 10px;
        
    }
    @keyframes transparency {
        0% {
            opacity: 1;
        }
        100% {
            opacity: 0;           
        }
    }
    @keyframes slide {
        0% {
            transform: translateY(-100px);
        }
        100% {
            transform: translateY(0px);
        }
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