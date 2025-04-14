<?php
    /*da aggiungere che viene riprestinato il precedente articolo*/ 
    session_start();
    if($_SERVER["REQUEST_METHOD"]==="POST"){
        header("Location: ../PAGINE/home.php");
    }

?>