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


    //chiude la connessione al DB
    public function closeConnection() {
        $this->conn->close();
    }

    public function getConnection() {
        return $this->conn;
    }


    //aggiunge un user al DB
    public function addUser($email, $password, $ruolo) {
       
        $stmt = $this->conn->prepare("INSERT INTO Utente (Email, Password, Stato) VALUES (?, ?, ?);");
        $state = 0;
        $stmt->bind_param("ssi", $email, $password,  $state);
        $stmt->execute();


        $stmt = $this->conn->prepare("INSERT INTO UtenteRuolo (ID_Utente, ID_Ruolo) VALUES ((SELECT MAX(Utente.ID) FROM Utente), (SELECT Ruolo.ID FROM Ruolo WHERE Ruolo.Ruolo = ?));");
        $stmt->bind_param("s", $ruolo);
        $stmt->execute();
       
    }

    public function getAdmin() {
        $result = $this->conn->query("SELECT * FROM wiki.Utente JOIN wiki.UtenteRuolo ON Utente.ID = UtenteRuolo.ID_Utente WHERE UtenteRuolo.ID_Ruolo = 3;");
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
    }

    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM wiki.Utente WHERE Utente.ID = ?;");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    //Change Status of the user
    public function changeUserStatus($bool, $id) {
        if ($bool) {
            $stmt = $this->conn->prepare("UPDATE wiki.Utente SET Utente.Stato = 1 WHERE Utente.ID = ?;");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        } else {
            $stmt = $this->conn->prepare("UPDATE wiki.Utente SET Utente.Stato = 0 WHERE Utente.ID = ?;");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }
    }

    //Get minimum ID
    public function getMinUser() {
        $result = $this->conn->query("SELECT MIN(Utente.ID) FROM Utente;");

        if ($result->num_rows >= 1) {
            $values = $result->fetch_assoc();
            return $values["MIN(Utente.ID)"];
        }
        return false;
    }

    //Get max ID
    public function getMaxUser() {
        $result = $this->conn->query("SELECT MAX(Utente.ID) FROM Utente;");

        if ($result->num_rows >= 1) {
            $values = $result->fetch_assoc();
            return $values["MAX(Utente.ID)"];
        }
        return false;
    }
    
    //restituisce gli utenti con ll account disabilitato
    public function getDisabled() {
        $result = $this->conn->query("SELECT * FROM Utente JOIN UtenteRuolo ON Utente.ID = UtenteRuolo.ID_Utente JOIN Ruolo ON Ruolo.ID = UtenteRuolo.ID_Ruolo WHERE Utente.Stato = 0;");

        if ($result->num_rows >= 1) {
            return $result;
        }
        return false;
    }

    //controlla se l utente esiste 
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




    //ritorna gli articoli in base al titolo
    public function getArticles($title) {
        $stmt = $this->conn->prepare("SELECT Bozza.ID, Bozza.ID_Utente, Bozza.Data_Valutate, Bozza.Data_Accettazione, Bozza.Title, Bozza.Abstract, Immagini.URL 
            FROM Bozza 
            JOIN ImmaginiBozza ON ImmaginiBozza.ID_Bozza = Bozza.ID 
            JOIN Immagini ON Immagini.ID = ImmaginiBozza.ID_Immagine 
            WHERE Bozza.Title LIKE ?");
        $title = "%" . $title . "%"; // Wildcard per la ricerca
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
    
    // prende le bozze che sono ancora da vedere per la review
public function getBozzeInAttesa() {
    $stmt = $this->conn->prepare("
        SELECT ID, Title, Abstract, ID_Utente 
        FROM Bozza 
        WHERE Data_Accettazione IS NULL AND Data_Rifiuto IS NULL");
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result;
    }
    return false;
}

// in base all'id della bozza, viene restituita la bozza
public function getBozzaById($idBozza) {
    $stmt = $this->conn->prepare("
        SELECT b.ID, b.Title, b.Abstract, b.ID_Utente, t.Testo as Text
        FROM Bozza b
        JOIN TestoBozza tb ON b.ID = tb.ID_Bozza
        JOIN Testo t ON tb.ID_Testo = t.ID
        WHERE b.ID = ?");
    $stmt->bind_param("i", $idBozza);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}

    // viene accettata la bozza
    public function approveBozza($idBozza) {
        $today = date("Y-m-d H:i:s");
        $stmt = $this->conn->prepare("
            UPDATE Bozza 
            SET Data_Accettazione = ?, Data_Valutate = ?
            WHERE ID = ?");
        $stmt->bind_param("ssi", $today, $today, $idBozza);
        return $stmt->execute();
    }

    // viene rifiutata la bozza
    public function rejectBozza($idBozza) {
        $today = date("Y-m-d H:i:s");
        $stmt = $this->conn->prepare("
            UPDATE Bozza 
            SET Data_Rifiuto = ?, Data_Valutate = ?
            WHERE ID = ?");
        $stmt->bind_param("ssi", $today, $today, $idBozza);
        return $stmt->execute();
    }

    // viene tolta la bozza dalla lista di attesa
    public function removeBozzaFromAttesa($idBozza) {
        // If you use the approve/reject methods above, this might not be necessary
        return true;
    }

    // viene preso l'ultimo articolo approvato
    public function getUltimoArticoloApprovato() {
        $stmt = $this->conn->prepare("
            SELECT b.ID, b.Title, b.Abstract, b.ID_Utente, t.Testo as Text
            FROM Bozza b
            JOIN TestoBozza tb ON b.ID = tb.ID_Bozza
            JOIN Testo t ON tb.ID_Testo = t.ID
            WHERE b.Data_Accettazione IS NOT NULL
            ORDER BY b.Data_Accettazione DESC
            LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }


}


?>
