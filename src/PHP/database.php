<?php

class Database {
    //Vars
    private static $id;
    //Connection
    private $conn;
    //Constructor
    public function __construct($servername, $username, $password, $dbname) {
        $this->conn = new mysqli($servername, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        } 
    }
    //Methods
    public function addUser($email, $password) {
        $stmt = $this->conn->prepare("INSERT INTO Utente (ID, Password, Email) VALUES (?, ?, ?);");
        $stmt->bind_param("iss", $this->id, $email, $password);
    }
}

?>