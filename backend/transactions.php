<?php
// funkcje do operacji na kontach

function addBalance($account, $valueToAdd): mixed
{
    if ($valueToAdd === '')
        return $account;
    $account += $valueToAdd;
    $_SESSION['message_status'] = 'success';
    $_SESSION['message'] = 'Adding balance successful';
    if ($_POST['action'] === 'deposit1') {
        array_unshift($_SESSION['history'], "<li class='success'><img src='./images/deposit-green.png' width='22px' height='22px'>" . $valueToAdd . " zlotych has been added to IKO account.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
    } else {
        array_unshift($_SESSION['history'], "<li class='success'><img src='./images/deposit-green.png' width='22px' height='22px'>" . $valueToAdd . " zlotych has been added to ING account.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
    }
    return $account;
}

function withdraw($account, $valueToWithdraw)
{
    if ($valueToWithdraw === '')
        return $account;
    if ($account < $valueToWithdraw) {
        $_SESSION['message_status'] = 'failure';
        $_SESSION['message'] = 'You don\'t have enough money to withdraw';
        if ($_POST['action'] === 'withdraw1') {
            array_unshift($_SESSION['history'], "<li class='failure'><img src='./images/withdraw-red.png' width='20px' height='20px'>Withdraw of " . $valueToWithdraw . " zlotych from IKO account has been canceled.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
        } else {
            array_unshift($_SESSION['history'], "<li class='failure'><img src='./images/withdraw-red.png' width='20px' height='20px'>Withdraw of " . $valueToWithdraw . " zlotych from ING account has been canceled.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
        }

    } else {
        $account -= $valueToWithdraw;
        $_SESSION['message_color'] = 'green';
        $_SESSION['message'] = 'Withdraw successful';
        if ($_POST['action'] === 'withdraw1') {
            array_unshift($_SESSION['history'], "<li class='success'><img src='./images/withdraw-green.png' width='20px' height='20px'>Withdraw of " . $valueToWithdraw . " zlotych from IKO account has been made.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
        } else {
            array_unshift($_SESSION['history'], "<li class='success'><img src='./images/withdraw-green.png' width='20px' height='20px'>Withdraw of " . $valueToWithdraw . " zlotych from ING account has been made.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
        }
    }
    return $account;
}

function transfer($accountFrom, $valueToTransfer, $accountTo)
{
    if ($valueToTransfer === '')
        return array($accountFrom, $accountTo);
    if ($accountFrom < $valueToTransfer) {
        $_SESSION['message_status'] = 'failure';
        $_SESSION['message'] = 'You don\'t have enough money to transfer';
        if ($_POST['action'] === 'transfer1') {
            array_unshift($_SESSION['history'], "<li class='failure'><img src='./images/transfer-red.png' width='20px' height='20px'>Transfer of " . $valueToTransfer . " zlotych from IKO to ING account has been canceled.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
        } else {
            array_unshift($_SESSION['history'], "<li class='failure'><img src='./images/transfer-red.png' width='20px' height='20px'>Transfer of " . $valueToTransfer . " zlotych from ING to IKO account has been canceled.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
        }
    } else {
        $accountFrom -= $valueToTransfer;
        $accountTo += $valueToTransfer;
        $_SESSION['message_status'] = 'success';
        $_SESSION['message'] = 'Transfer successful';
        if ($_POST['action'] === 'transfer1') {
            array_unshift($_SESSION['history'], "<li class='success'><img src='./images/transfer-green.png' width='20px' height='20px'>Transfer of " . $valueToTransfer . " zlotych from IKO to ING account has been made.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
        } else {
            array_unshift($_SESSION['history'], "<li class='success'><img src='./images/transfer-green.png' width='20px' height='20px'>Transfer of " . $valueToTransfer . " zlotych from ING to IKO account has been made.<span>" . date("H:i [d-m-Y]", time()) . "</span></li>");
        }
    }
    return array($accountFrom, $accountTo);
}