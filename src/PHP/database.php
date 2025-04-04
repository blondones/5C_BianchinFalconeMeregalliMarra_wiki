<?php

class Database {

    //
    //  Vars
    //
    private static $id = 2; // NOTA: L'uso di un ID statico gestito manualmente è sconsigliato. Usa AUTO_INCREMENT nel DB.
    private $conn;

    //
    //  Constructor
    //

    public function __construct($servername, $username, $password, $dbname) {
        // Abilita il reporting degli errori per mysqli
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $this->conn = new mysqli($servername, $username, $password, $dbname);
            // Imposta il charset a utf8mb4 per supportare un'ampia gamma di caratteri
            $this->conn->set_charset("utf8mb4");
        } catch (mysqli_sql_exception $e) {
            // Logga l'errore invece di usare die() in produzione
            error_log("Connection failed: " . $e->getMessage());
            die("Connection failed. Please check server logs."); // Messaggio generico per l'utente
        }
    }

    //
    //  Methods
    //

    //Close Connection to the DB
    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    //Adds a user to the DB
    public function addUser($email, $password, $ruolo) {
        // NOTA: Considera di usare password_hash() per la password prima di salvarla!
        // NOTA: La gestione dell'ID statico è problematica.
        $newUserId = self::$id; // Usa una variabile locale per coerenza nell'operazione

        $sqlUser = "INSERT INTO Utente (ID, Username, Password, Email) VALUES (?, ?, ?, ?)";
        // Assumendo che manchi Username nel DB schema originale, ma sia desiderato. Adattare se necessario.
        // Se Username non esiste, rimuovilo e il bind_param "s" corrispondente.
        // Ho aggiunto un Username fittizio basato sull'email per l'esempio.
        $username = explode('@', $email)[0]; // Crea un username dall'email (esempio)

        $stmtUser = $this->conn->prepare($sqlUser);
        // Adatta i tipi se Username non è presente: "iss" -> "iss" senza la s per username
        $stmtUser->bind_param("isss", $newUserId, $username, $password, $email);

        $sqlRole = "INSERT INTO UtenteRuolo (ID_Utente, ID_Ruolo) VALUES (?, (SELECT r.ID FROM Ruolo r WHERE r.Ruolo = ?))";
        $stmtRole = $this->conn->prepare($sqlRole);
        // Assumendo che il ruolo sia passato come stringa (es. "Admin", "User")
        $stmtRole->bind_param("is", $newUserId, $ruolo);

        // Transazione per assicurare che entrambe le insert vadano a buon fine o nessuna
        $this->conn->begin_transaction();
        try {
            $stmtUser->execute();
            $stmtRole->execute();
            $this->conn->commit();
            self::$id++; // Incrementa l'ID statico SOLO se tutto va a buon fine
            $stmtUser->close();
            $stmtRole->close();
            return true;
        } catch (mysqli_sql_exception $e) {
            $this->conn->rollback();
            error_log("Errore in addUser: " . $e->getMessage());
            if ($stmtUser) $stmtUser->close();
            if ($stmtRole) $stmtRole->close();
            return false;
        }
    }

    //Check if the user exists
    public function checkUser($email, $password) {
         // NOTA: Dovresti confrontare l'hash della password, non la password in chiaro!
         // Esempio: SELECT ID, Password FROM Utente WHERE Email = ?
         // Poi recupera l'hash e usa password_verify($password, $hash_dal_db)
        $stmt = $this->conn->prepare("SELECT ID FROM Utente WHERE Email = ? AND Password = ?");
        if (!$stmt) {
             error_log("Prepare failed (checkUser): (" . $this->conn->errno . ") " . $this->conn->error);
             return false;
        }
        $stmt->bind_param("ss", $email, $password);
        if(!$stmt->execute()){
            error_log("Execute failed (checkUser): (" . $stmt->errno . ") " . $stmt->error);
            $stmt->close();
            return false;
        }
        $result = $stmt->get_result();
        $userId = false;
        if ($result->num_rows === 1) {
            // Recupera l'ID se l'utente è trovato
             $row = $result->fetch_assoc();
             $userId = $row['ID'];
        }
        $stmt->close();
        return $userId; // Ritorna l'ID dell'utente o false
    }

    //Get the role of the user
    public function getRole($ID) {
        // Corretto il nome della tabella Ruoli.Ruoli a Ruolo.Ruolo come da schema
        $sql = "SELECT r.Ruolo FROM Utente u JOIN UtenteRuolo ur ON u.ID = ur.ID_Utente JOIN Ruolo r ON r.ID = ur.ID_Ruolo WHERE u.ID = ?";
        $stmt = $this->conn->prepare($sql);
         if (!$stmt) {
             error_log("Prepare failed (getRole): (" . $this->conn->errno . ") " . $this->conn->error);
             return false; // O null, o lancia eccezione
        }
        $stmt->bind_param("i", $ID);
        if(!$stmt->execute()){
            error_log("Execute failed (getRole): (" . $stmt->errno . ") " . $stmt->error);
            $stmt->close();
            return false;
        }
        $result = $stmt->get_result();
        $role = false; // Default a false se non trovato
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $role = $row['Ruolo']; // Ritorna la stringa del ruolo
        }
        $stmt->close();
        return $role; // Ritorna la stringa del ruolo o false
    }

    //Get Articles
    /**
     * Cerca articoli (bozze o archiviati) per titolo.
     *
     * @param string $title Il termine di ricerca per il titolo.
     * @param string $scope L'ambito della ricerca: 'active' per Bozza, 'archived' per Bozza_Archiviata. Default 'active'.
     * @return array Un array di articoli trovati, ognuno con title, abstract, texts (array), image_urls (array). Ritorna array vuoto se non trova nulla o in caso di errore.
     */
    public function getArticles($title, $scope = 'active') {
        $results = [];
        $searchTerm = '%' . $title . '%'; // Per la ricerca LIKE
        $separator = '|||'; // Separatore per GROUP_CONCAT

        // Validazione basilare dello scope
        if ($scope !== 'active' && $scope !== 'archived') {
            error_log("Invalid scope provided to getArticles: " . $scope . ". Defaulting to 'active'.");
            $scope = 'active';
        }

        // Determina le tabelle e le colonne corrette in base allo scope
        if ($scope === 'active') {
            $mainTable = "Bozza";
            $mainAlias = "b";
            $textJoinTable = "TestoBozza";
            $textJoinAlias = "tb";
            $textJoinColumn = "ID_Bozza";
            $imageJoinTable = "ImmaginiBozza";
            $imageJoinAlias = "ib";
            $imageJoinColumn = "ID_Bozza";
            $mainIdColumn = "ID";
        } else { // $scope === 'archived'
            $mainTable = "Bozza_Archiviata";
            $mainAlias = "ba";
            $textJoinTable = "TestoBozzaArchiviata";
            $textJoinAlias = "tba";
            $textJoinColumn = "ID_BozzaArchiviata"; // Assumendo che punti all'ID di Bozza_Archiviata
            $imageJoinTable = "ImmaginiBozzaArchiviata";
            $imageJoinAlias = "iba";
            $imageJoinColumn = "ID_BozzaArchiviata"; // Assumendo che punti all'ID di Bozza_Archiviata
            $mainIdColumn = "ID"; // ID della tabella Bozza_Archiviata
        }

        // Costruisci la query SQL
        $sql = "
            SELECT
                {$mainAlias}.Title AS title,
                {$mainAlias}.Abstract AS abstract,
                GROUP_CONCAT(DISTINCT t.Testo SEPARATOR '{$separator}') AS texts,
                GROUP_CONCAT(DISTINCT i.URL SEPARATOR '{$separator}') AS image_urls
            FROM
                {$mainTable} AS {$mainAlias}
            LEFT JOIN
                {$textJoinTable} AS {$textJoinAlias} ON {$mainAlias}.{$mainIdColumn} = {$textJoinAlias}.{$textJoinColumn}
            LEFT JOIN
                Testo AS t ON {$textJoinAlias}.ID_Testo = t.ID
            LEFT JOIN
                {$imageJoinTable} AS {$imageJoinAlias} ON {$mainAlias}.{$mainIdColumn} = {$imageJoinAlias}.{$imageJoinColumn}
            LEFT JOIN
                Immagini AS i ON {$imageJoinAlias}.ID_Immagine = i.ID
            WHERE
                {$mainAlias}.Title LIKE ?
            GROUP BY
                {$mainAlias}.{$mainIdColumn}, {$mainAlias}.Title, {$mainAlias}.Abstract
        ";

        $stmt = $this->conn->prepare($sql);

        // Controllo preparazione statement
        if (!$stmt) {
             error_log("Prepare failed (getArticles): (" . $this->conn->errno . ") " . $this->conn->error . " SQL: " . $sql);
             return []; // Ritorna array vuoto in caso di errore
        }

        // Bind del parametro
        if (!$stmt->bind_param("s", $searchTerm)) {
            error_log("Binding parameters failed (getArticles): (" . $stmt->errno . ") " . $stmt->error);
            $stmt->close();
            return [];
        }

        // Esecuzione query
        if (!$stmt->execute()) {
            error_log("Execute failed (getArticles): (" . $stmt->errno . ") " . $stmt->error);
            $stmt->close();
            return [];
        }

        // Ottenimento risultati
        $result = $stmt->get_result();
        if (!$result) {
             error_log("Getting result set failed (getArticles): (" . $stmt->errno . ") " . $stmt->error);
             $stmt->close();
             return [];
        }

        // Fetch e processamento risultati
        while ($row = $result->fetch_assoc()) {
            // Splitta le stringhe concatenate in array, gestendo i casi NULL
             $row['texts'] = isset($row['texts']) ? explode($separator, $row['texts']) : [];
             $row['image_urls'] = isset($row['image_urls']) ? explode($separator, $row['image_urls']) : [];
             $results[] = $row; // Aggiunge la riga processata all'array dei risultati
        }

        // Chiusura statement
        $stmt->close();

        return $results;
    }

     // Metodo __destruct per chiudere la connessione quando l'oggetto viene distrutto
     public function __destruct() {
        $this->closeConnection();
    }
}

?>