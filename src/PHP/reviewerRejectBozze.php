<?php
    session_start();
    
    require("config.php");
    require("database.php");

    if(!isset($_SESSION["user_id"]) || !isset($_SESSION["id_bozzaAttuale"])){
        header("Location: ../PAGINE/login.php");
        exit;
    }

    $idBozza = $_SESSION["id_bozzaAttuale"];
    $db = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
    
    // Update the draft status in database to rejected
    $db->rejectBozza($idBozza);
    
    // Remove draft from the pending list
    $db->removeBozzaFromAttesa($idBozza);
    
    // Just redirect to home without changing article
    header("Location: ../PAGINE/home.php");
?>