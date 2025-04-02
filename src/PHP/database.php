<?php

class Database {

    //
    //  Vars
    //
    private static $id;
    private $conn;

    //
    //  Constructor
    //

    public function __construct($servername, $username, $password, $dbname) {
        $this->conn = new mysqli($servername, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        } 
    }

    //
    //  Methods
    //

    //Close Connection to the DB
    public function closeConnection() {
        $this->conn->close();
    }

    //Adds a user to the DB
    public function addUser($email, $password) {
        $stmt = $this->conn->prepare("INSERT INTO Utente (ID, Password, Email) VALUES (?, ?, ?);");
        $stmt->bind_param("iss", $this->id, $email, $password);
        $stmt->execute();
        return $stmt->get_result();
    }
        
    //Check if the user exists
    public function checkUser($email, $password) {
        $stmt = $this->conn->prepare("SELECT ID FROM Utente WHERE Email = ? AND Password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();

        if ($stmt->get_result()->num_rows == 0) {
            return $stmt->get_result();
        }
        return false;
    }

    //Get the role of the user
    public function getRole($ID) {
        $stmt = $this->conn->prepare("SELECT ruolo FROM Utente (JOIN UtenteRuolo ON Utente.ID = UtenteRuolo.ID_Utente) JOIN Ruolo ON Ruolo.ID = UtenteRuolo.ID_Ruolo WHERE Utente.ID = ?");
        $stmt->bind_param("i", $ID);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) {
            return $stmt->get_result();
        }
        return false;
    }
}

?>