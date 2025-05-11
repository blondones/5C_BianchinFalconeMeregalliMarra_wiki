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
        $title = htmlspecialchars($result_set['Title']);
        $abstract = nl2br(htmlspecialchars($result_set['Abstract']));
        $text = nl2br(htmlspecialchars($result_set['Text']));
        
        // Prendiamo anche l'immagine associata
        $conn = $db->getConnection();
        $stmt = $conn->prepare("SELECT i.URL FROM ImmaginiBozza ib JOIN Immagini i ON ib.ID_Immagine = i.ID WHERE ib.ID_Bozza = ?");
        $stmt->bind_param("i", $idBozza);
        $stmt->execute();
        $result = $stmt->get_result();
        $imageUrl = null;
        if ($imgRow = $result->fetch_assoc()) {
            $imageUrl = htmlspecialchars($imgRow['URL']);
        }
        $stmt->close();
        $db->closeConnection();
    
        // Se non c'è immagine, ne usiamo una di default
        if (!$imageUrl) {
            $imageUrl = "https://www.gannett-cdn.com/authoring/2011/01/27/NCOU/ghows-DA-7f3cea74-5a72-4ac7-99f5-2add0ccea1e0-b7824ad2.jpeg?crop=1886,1066,x0,y0&width=2560";
        }
    
        $articoloContainer = <<<HTML
        <div id="article-container">
            <h1 id="scrittaReviewEffettiva">{$title}</h1>
            <p id="testoReview1">{$abstract}</p>
            <img src="{$imageUrl}" alt="Immagine articolo" id="immagineVarano" style="max-width: 100%; height: auto; border-radius: 12px;">
            <br><br><br><br><br><br><br>
            <hr>
            <br><br><br>
            <img src="{$imageUrl}" alt="Immagine articolo" id="immagineVarano2" style="max-width: 100%; height: auto; border-radius: 12px;">
            <p id="testoReview2">{$text}</p>
        </div>
        HTML;
    
        $_SESSION["articoloContainer"] = $articoloContainer;
    }
    
    
    // Remove draft from the pending list
    $db->removeBozzaFromAttesa($idBozza);
    
    header("Location: ../PAGINE/home.php");
?>