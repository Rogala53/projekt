<?php

class Account implements IAccount
{
    private string $name;
    private float $balance;

    function __construct(string $name) {
        $this->name = $name;
        $this->balance = 0;
    }

    function get_balance() {
        return $this->balance;
    }

    function get_name() {
        return $this->name;
    }

    function add_balance($conn, float $value_to_add) {
        try {
            $stmt = $conn->prepare("UPDATE accounts SET balance = :balance WHERE name = :name");
            $bal = $this->balance + $value_to_add;
            $stmt->bindParam(':balance', $bal);
            $stmt->bindParam(':name', $this->name);
            $stmt->execute();
            $success = $stmt->rowCount() != '0';
            if ($success) {
                $this->balance += $value_to_add;
                return true;
                
            }
            return false;

        } catch (Exception $e) {
            echo "Nie udało się dodać balansu: " . $e->getMessage();
            return false;
        }
    }

    function withdraw($conn, float $value_to_withdraw) {
        try {
            
            $stmt = $conn->prepare("UPDATE accounts SET balance = :balance WHERE name = :name");
            $bal = $this->balance - $value_to_withdraw;
            $stmt->bindParam(':balance', $bal);
            $stmt->bindParam(':name', $this->name);
            $stmt->execute();
            $success = $stmt->rowCount() != '0';
            if ($success) {
                $this->balance -= $value_to_withdraw;
                return true;
            }
            return false;

        } catch (Exception $e) {
            echo "Nie udało się odjąć balansu: " . $e->getMessage();
            return false;
        }
    }
}