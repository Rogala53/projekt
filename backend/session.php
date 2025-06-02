<?php
include_once("Db_handler.php");
include_once ("IAccount.php");
include_once("Account.php");
include_once('Transactions_handler.php');
// obsługa sesji i formularza
session_start();
$db_handler = new Db_handler('localhost', 'root', '', 'prog_aplik');
$db_handler->connect();
$tr_handler  = new Transactions_handler();
$conn = $db_handler->get_connection();
$accounts = $db_handler->get_accounts();
if(empty($accounts)) {
    echo "Brak kont";
}
if (!isset($_SESSION['account1'])) {
    $_SESSION['account1'] = new Account($accounts[0]['name']);
    $_SESSION['account2'] = new Account($accounts[1]['name']);
    $_SESSION['form_token'] = bin2hex(random_bytes(16));
    $_SESSION['message'] = '';
    $_SESSION['message_status'] = '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['form_token'] === $_SESSION['form_token']) {
        switch ($_POST['action']) {
            case 'deposit1':
                $tr_handler->add_balance($conn, $_SESSION['account1'], $_POST['valueToAdd1']);
                break;
            case 'withdraw1':
                $tr_handler->withdraw_balance($conn, $_SESSION['account1'], $_POST['valueToWithdraw1']);
                break;
            case 'transfer1':
                $tr_handler->transfer_balance($conn, $_SESSION['account1'], $_SESSION['account2'], $_POST['valueToTransfer1']);
                break;
            case 'deposit2':
                $tr_handler->add_balance($conn, $_SESSION['account2'], $_POST['valueToAdd2']);
                break;
            case 'withdraw2':
                $tr_handler->withdraw_balance($conn, $_SESSION['account2'], $_POST['valueToWithdraw2']);
                break;
            case 'transfer2':
                $tr_handler->transfer_balance($conn, $_SESSION['account2'], $_SESSION['account1'], $_POST['valueToTransfer2']);
                break;
        }
        $_SESSION['form_token'] = bin2hex(random_bytes(16));
    }
}