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
    
    // Update the draft status in database to approved
    $db->approveBozza($idBozza);
    
    // Get the approved draft content to display on home page
    $result_set = $db->getBozzaById($idBozza);
    
    if($result_set) {
        // Create HTML content for the home page
        $title = htmlspecialchars($result_set['Title']);
        $abstract = nl2br(htmlspecialchars($result_set['Abstract']));
        $text = nl2br(htmlspecialchars($result_set['Text']));
        
        // You could fetch images here too
        
        $articoloContainer = <<<HTML
        <div id="article-container">
            <h1 id="scrittaReviewEffettiva">{$title}</h1>
            <p id="testoReview1">{$abstract}</p>
            <img src="https://www.gannett-cdn.com/authoring/2011/01/27/NCOU/ghows-DA-7f3cea74-5a72-4ac7-99f5-2add0ccea1e0-b7824ad2.jpeg?crop=1886,1066,x0,y0&width=2560" alt="immagineVarano" id="immagineVarano">
            <br><br><br><br><br><br><br>
            <hr>
            <br><br><br>
            <img src="https://www.gannett-cdn.com/authoring/2011/01/27/NCOU/ghows-DA-7f3cea74-5a72-4ac7-99f5-2add0ccea1e0-b7824ad2.jpeg?crop=1886,1066,x0,y0&width=2560" alt="immagineVarano2" id="immagineVarano2">
            <p id="testoReview2">{$text}</p>
        </div>
        HTML;
        
        $_SESSION["articoloContainer"] = $articoloContainer;
    }
    
    // Remove draft from the pending list
    $db->removeBozzaFromAttesa($idBozza);
    
    header("Location: ../PAGINE/home.php");
?>