<?php 
/*da aggiungere che nella home viene visto il nuovo articolo (la ex bozza) */
    session_start();
    if(!isset($_SESSION["email"])){
        header("Location: ../PAGINE/login.php");
    }
    if($_SERVER["REQUEST_METHOD"]==="POST"){
        header("Location: ../PAGINE/home.php");
        //qua viene messa la parte che si collega al db, prende il testo dalla bozza del database e lo inserisce all interno del nuovo articolo 
        $db=new Database($SERVERNAME,$USERNAME,$PASSWORD,$DBNAME); //connessione al db fatta
        
        


    }







?>