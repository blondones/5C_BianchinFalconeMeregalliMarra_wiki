<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviewer Lista Bozze</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <!--NAVBAR-->
    <div id="navbar-container" data-navbar="navbar-logout-RW"></div>


    <h1>Reviews</h1>
    <div class="role-container">
        <?php 
            require("../PHP/config.php");
            require("../PHP/database.php");
            $DB = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
            $bozze = $DB->getBozzeInAttesa(); // Create this method in the Database class
            if($bozze && $bozze->num_rows > 0) {
                while($row = $bozze->fetch_assoc()) {
                    echo '<div class="role-info">';
                    echo '<p>' . htmlspecialchars($row['Title']) . '</p>';
                    echo '</div>';
                    echo '<form action="../PAGINE/reviewer_visioneBozza.php" method="GET">';
                    echo '<input type="hidden" name="idBozza" value="' . $row['ID'] . '">';
                    echo '<div class="role-buttons">';
                    echo '<button id="bottoneReview" type="submit">Check</button>';
                    echo '</div>';
                    echo '</form>';
                }
            } else {
                echo '<p>nessuna bozza da valutare.</p>';
            }
        
        ?>
        <form action="../PHP/reviewerHandling.php" method="POST">
        </form>
            
    </div>
    

    <script src="../JS/navbar.js"></script>
</body>
</html>
