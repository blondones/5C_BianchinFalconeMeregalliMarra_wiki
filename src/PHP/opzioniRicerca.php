<?php
    session_start();
    
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

require_once 'config.php'; // Include il file config.php per le credenziali del database
require_once 'database.php'; // Include la classe Database

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['search'])) {
        exit();
    } else {
        $testo = test_input($_POST['search']);

        $db = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
        $result = $db->getArticles($testo);

        if ($result) {
            $articles = [];
            while ($row = $result->fetch_assoc()) {
                $articles[] = $row;
            }
            echo json_encode($articles); // Restituisce i dati in formato JSON
            $_SESSION['lista_articoli'] = $articles; // Salva i dati nella sessione
        } else {
            redirect('home.php');
        }

        $db->closeConnection();
    }
}
?>

