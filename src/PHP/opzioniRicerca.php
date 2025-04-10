<?php
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
        echo "Testo elaborato: " . $testo;
    }
}
?>