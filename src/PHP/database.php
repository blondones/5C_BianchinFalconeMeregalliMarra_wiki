<?php

class Database {

    //
    //  Vars
    //
    private static $id = 2;
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
    public function addUser($email, $password, $ruolo) {
        $stmt = $this->conn->prepare("INSERT INTO Utente (ID, Email, Password, Stato) VALUES (?, ?, ?, ?);");
        $state = 0;
        $stmt->bind_param("issi", $this->id, $password, $email, $state);
        $stmt->execute();

        $stmt = $this->conn->prepare("INSERT INTO UtenteRuolo (ID_Utente, ID_Ruolo) VALUES (?, (SELECT Ruoli.ID FROM Ruoli WHERE Ruoli.Ruoli = ?));");
        $stmt->bind_param("ii", $this->id, $ruolo);
        $stmt->execute();
        
        $this->id+=1;
    }

    //Accept user
    public function acceptUser() {
        
    }
        
    //Check if the user exists, and returns it's Roll and ID
    public function checkUser($email, $password) {
        $stmt = $this->conn->prepare("SELECT Utente.ID, Ruolo.Ruolo, Utente.Stato FROM Utente JOIN UtenteRuolo ON Utente.ID = UtenteRuolo.ID_Utente JOIN Ruolo ON Ruolo.ID= UtenteRuolo.ID_Ruolo WHERE Utente.Email = ? AND Utente.Password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        }
        return false;
    }


    //Get Articles
    public function getArticles($title) {
        $stmt = $this->conn->prepare("SELECT titolo FROM bozza WHERE LIKE(?)");
        $allTitles = $title."*";
        $stmt->bind_param("s", $allTitles);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result;
        }
        return false;
    }
}

?>