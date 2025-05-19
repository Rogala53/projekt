<?php
include_once 'transactions.php';
// obsługa sesji i formularza
session_start();
if (!isset($_SESSION['account_1_balance'])) {
    $_SESSION['account_1_balance'] = 0;
    $_SESSION['account_2_balance'] = 0;
    $_SESSION['form_token'] = bin2hex(random_bytes(16));
    $_SESSION['message_status'] = '';
    $_SESSION['message'] = '';
    $_SESSION['history'] = [];
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