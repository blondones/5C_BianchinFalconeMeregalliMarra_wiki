<?php
    /*da aggiungere la parte dove viene vista la lista degli articoli dinamicamente */
    session_start();
    

    if(!isset($_SESSION["user_id"])){
        header("Location: ../PAGINE/login.php");
    }
    if($_SERVER["REQUEST_METHOD"]==="POST"){
        header("Location: ../PAGINE/reviewer_visioneBozza.php");
    }












?>