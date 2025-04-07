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
        $stmt->bind_param("iss", $this->id, $password, $email, $state);
        $stmt->execute();

        $stmt = $this->conn->prepare("INSERT INTO UtenteRuolo (ID_Utente, ID_Ruolo) VALUES (?, (SELECT Ruoli.ID FROM Ruoli WHERE Ruoli.Ruoli = ?));");
        $stmt->bind_param("ii", $this->id, $ruolo);
        $stmt->execute();
        
        $this->id+=1;

        return true;
    }

    //Accept user
    public function acceptUser() {
        
    }
        
    //Check if the user exists, and returns it's Roll and ID
    public function checkUser($email, $password) {
        $stmt = $this->conn->prepare("SELECT Utente.ID, Ruolo.Ruolo FROM Utente JOIN UtenteRuolo ON Utente.ID = UtenteRuolo.ID_Utente JOIN Ruolo ON Ruolo.ID= UtenteRuolo.ID_Ruolo WHERE Utente.Email = ? AND Utente.Password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            return $result;
        }
        return false;
    }

<<<<<<< HEAD
=======
    //Get the role of the user
    public function getRole($ID) {
        $stmt = $this->conn->prepare("SELECT Ruolo.Ruolo FROM Utente JOIN UtenteRuolo ON Utente.ID = UtenteRuolo.ID_Utente JOIN Ruolo ON Ruolo.ID= UtenteRuolo.ID_Ruolo WHERE Utente.ID = ?;");
        $stmt->bind_param("i", $ID);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result;
        }
        return false;
    }

>>>>>>> 241f00271e66a8a844eccabf2250e53d2a896d85
    //Get Articles
    public function getArticles($title) {
        $stmt = $this->conn->prepare("SELECT titolo FROM bozza WHERE LIKE(?)");
        $stmt->bind_param("s", $title."*");
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result;
        }
        return false;
    }
}

?>registerHandling