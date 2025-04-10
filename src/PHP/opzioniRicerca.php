<?php
/*function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Verifica se il campo 'search' è stato inviato e non è vuoto
    if(empty($_POST['search'])){
         exit();
    } else {
        $testo = test_input($_POST['search']);


        echo "Testo elaborato: " . $testo;
    }
}
    */
    require_once 'database.php'; // Include la classe Database


function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Verifica se il campo 'search' è stato inviato e non è vuoto
    if(empty($_POST['search'])){
        exit();
    } else {
        $testo = test_input($_POST['search']);
       
        // Connessione al database
        $db = new Database($servername, $username, $password, $dbname); // Sostituisci con i tuoi parametri
        $result = $db->getArticles($testo);


        if ($result) {
            // Recupera i dati dell'articolo
            $article = $result->fetch_assoc();
            echo json_encode($article); // Restituisce i dati in formato JSON
        } else {
            echo json_encode(["error" => "Articolo non trovato"]);
        }


        // Chiude la connessione al database
        $db->closeConnection();
    }
}
?>
