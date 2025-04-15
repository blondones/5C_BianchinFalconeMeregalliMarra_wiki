<?php 
/*da aggiungere che nella home viene visto il nuovo articolo (la ex bozza) */
    session_start();
    if(!isset($_SESSION["email"])){
        header("Location: ../PAGINE/login.php");
    }
    if($_SERVER["REQUEST_METHOD"]==="POST"){
        header("Location: ../PAGINE/home.php");
    }








?>