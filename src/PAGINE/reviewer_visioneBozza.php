<?php
    session_start();
    
    if(!isset($_SESSION["user_id"])){
        header("Location: ../PAGINE/login.php");
        exit;
    }
    
    // Get the draft ID
    if(!isset($_GET['idBozza'])) {
        header("Location: ../PAGINE/reviewer_listaBozze.php");
        exit;
    }
    
    $idBozza = intval($_GET['idBozza']);
    $_SESSION['id_bozzaAttuale'] = $idBozza;
    
    require("../PHP/config.php");
    require("../PHP/database.php");
    
    $DB = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
    $bozza = $DB->getBozzaById($idBozza); // Create this method
    
    if(!$bozza) {
        header("Location: ../PAGINE/reviewer_listaBozze.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviewer Visione Bozza</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <div id="navbar-container" data-navbar="navbar-logout-RW"></div>

    <h1 id="scrittaReviewEffettiva"><?php echo htmlspecialchars($bozza['Title']); ?></h1>
    <p id="testoReview1"><?php echo htmlspecialchars($bozza['Abstract']); ?></p> 
    
    <!-- Add code for images and text based on your database structure -->
    
    <div class="button-container">
        <form action="../PHP/reviewerApproveBozze.php" method="POST">
            <button id="bottoneApprovazione" class="accept">Accept</button>
        </form>
        
        <span></span>
        <form action="../PHP/reviewerRejectBozze.php" method="POST">
            <button id="bottoneReject" class="reject">Reject</button>
        </form>
    </div>
    
    <script src="../JS/navbar.js"></script>
</body>
</html>