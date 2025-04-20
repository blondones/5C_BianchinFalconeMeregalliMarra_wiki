<?php


class Database {


    //
    //  Vars
    //
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

    public function getConnection() {
        return $this->conn;
    }


    //Adds a user to the DB
    public function addUser($email, $password, $ruolo) {
       
        $stmt = $this->conn->prepare("INSERT INTO Utente (Email, Password, Stato) VALUES (?, ?, ?);");
        $state = 0;
        $stmt->bind_param("ssi", $email, $password,  $state);
        $stmt->execute();


        $stmt = $this->conn->prepare("INSERT INTO UtenteRuolo (ID_Utente, ID_Ruolo) VALUES ((SELECT MAX(Utente.ID) FROM Utente), (SELECT Ruolo.ID FROM Ruolo WHERE Ruolo.Ruolo = ?));");
        $stmt->bind_param("s", $ruolo);
        $stmt->execute();
       
    }


    //Accept user
    public function acceptUser() {
       
    }
    
    //Get all disabled accounts
    public function getDisabled() {
        $result = $this->conn->query("SELECT * FROM Utente JOIN UtenteRuolo ON Utente.ID = UtenteRuolo.ID_Utente JOIN Ruolo ON Ruolo.ID = UtenteRuolo.ID_Ruolo WHERE Utente.Stato = 0;");

        if ($result->num_rows >= 1) {
            return $result;
        }
        return false;
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
        $stmt = $this->conn->prepare("SELECT ID, ID_Utente, Data_Valutate, Data_Accettazione, Title, Abstract FROM Bozza WHERE Title LIKE ?");
        $title = "%" . $title . "%"; // Aggiunge wildcard per corrispondenze parziali
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result;
        }
        return false;
    }


    public function getTesto($id) {
        $stmt = $this->conn->prepare("SELECT Testo FROM Testo WHERE id LIKE ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result;
        }
        return false;
    }


}


?>
