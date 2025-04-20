<?php 
/*da aggiungere che nella home viene visto il nuovo articolo (la ex bozza) */
    session_start();
    
    require("config.php");
    require("database.php");

    if(!isset($_SESSION["user_id"])){
        header("Location: ../PAGINE/login.php");
    }

    $db=new Database($SERVERNAME,$USERNAME,$PASSWORD,$DBNAME); //connessione al db fatta
    $result_set = $db->getTesto("7");
    $testoBozzaAccettata;
    while($row = $result_set->fetch_assoc()){
        $testoBozzaAccettata = $row["Testo"];
        //echo $testoBozzaAccettata;
    }
    //adesso io in $testoBozzaAccettata ho il testo della bozza accettata, e devo fare la redirect alla pagina home.php e imposto il $testobozzaAccettata come testo principale
    $_SESSION["articoloContainer"] = $testoBozzaAccettata;
    $DP=$_SESSION["articoloContainer"];
    //echo $DP;
    header("Location: ../PAGINE/home.php");





?>