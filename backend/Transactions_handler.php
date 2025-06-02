<?php

class Transactions_handler
{
    private $history_list;

    function set_history_list($conn) {
        $stmt = $conn->prepare("SELECT status, message, DATE_FORMAT(date, '%d-%m-%Y %H:%i') as date FROM history");
        $stmt->execute();
        $this->history_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_history() {
        return $this->history_list;
    }

    function create_history_event($status, $message, $date) {
        $event = [
            'status' => $status,
            'message' => $message,
            'date' => $date
        ];
        return $event;
    }
    function add_history_event($conn, $event) {
        try {
            $stmt = $conn->prepare("INSERT INTO history (status, message, date) VALUES ( :status, :message, :date )");
            $stmt->bindParam(':status', $event['status']);
            $stmt->bindParam(':message', $event['message']);
            $stmt->bindParam(':date', $event['date']);
            $stmt->execute();
            return true;
        } catch(Exception $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
    }
    function add_balance($conn, Account $account, $value_to_add) {

        $account->add_balance($conn, $value_to_add);
        $account_name = $account->get_name();
        $_SESSION['message_status'] = 'success';
        $_SESSION['message'] = 'Adding balance successful';
        $status = true;
        $message = "$value_to_add zlotych has been added to $account_name account.";
        $date = date("Y-m-d H:i:s", time());

        $event = $this->create_history_event($status, $message, $date);
        $this->add_history_event($conn, $event);
    }

    function withdraw_balance($conn, Account $account, $value_to_withdraw) {
        $balance = $account->get_balance();
        $account_name = $account->get_name();
        try {
            if($balance < $value_to_withdraw) {
                throw new Exception("Balance of $account_name account is not enough to withdraw $value_to_withdraw zł");
            }
            if(!is_numeric($value_to_withdraw)) {
                throw new Exception("Withdraw value is not a number");
            }

            $success = $account->withdraw($conn, $value_to_withdraw);
            if ($success) {
                $_SESSION['message_status'] = 'success';
                $_SESSION['message'] = "Withdraw of $value_to_withdraw from $account_name is successful";
            }
        } catch (Exception $e) {
            $_SESSION['message_status'] = 'failure';
            $_SESSION['message'] = $e->getMessage();
        } finally {
            $message_status = $_SESSION['message_status'];
            if ($message_status == 'success') {
                $status = 'success';
                $message = "Withdraw of $value_to_withdraw zlotych from $account_name account has been made.";
            } else {
                $status = 'failure';
                $message = "Withdraw of $value_to_withdraw zlotych from $account_name account has been canceled.";
            }
            $date = date("Y-m-d H:i:s", time());
            $event =  $this->create_history_event($status, $message, $date);
            $this->add_history_event($conn, $event);
        }
    }

    function transfer_balance($conn, Account $sender, Account $receiver, $value_to_transfer) {
        $sender_name = $sender->get_name();
        $receiver_name = $receiver->get_name();
        $sender_balance = $sender->get_balance();

        if($sender_balance < $value_to_transfer) {
            $_SESSION['message_status'] = 'failure';
            $_SESSION['message'] = 'You don\'t have enough money to transfer';
            $status = 'failure';
            $message = "Transfer of $value_to_transfer zlotych from $sender_name to $receiver_name account has been canceled.";
        } else {
            $sender->withdraw($conn, $value_to_transfer);
            $receiver->add_balance($conn, $value_to_transfer);
            $_SESSION['message_status'] = 'success';
            $_SESSION['message'] = 'Transfer successful';
            $status = 'success';
            $message = "Transfer of $value_to_transfer zlotych from $sender_name to $receiver_name account has been made.";
        }
        $date = date("Y-m-d H:i:s", time());
        $event = $this->create_history_event($status, $message, $date);
        $this->add_history_event($conn, $event);
    }
}