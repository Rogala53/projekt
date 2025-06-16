<?php
class Db_handler {

    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    public function connect() {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn = $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function get_connection() {
        return $this->conn;
    }

    public function get_accounts_names_and_balance_from_db() {
        try {
            $stmt = $this->conn->prepare("SELECT name, balance FROM accounts");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            echo "Failed getting accounts: " . $e->getMessage();
        }
    }

    public function get_history() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM history");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Failed getting history: " . $e->getMessage();
        }
    }
}