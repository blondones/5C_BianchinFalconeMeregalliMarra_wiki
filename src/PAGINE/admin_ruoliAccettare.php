<?php 
    session_start();     

    function redirect($url) {
        header('Location: '.$url);
        die();
    }

    if ($_SESSION["user_role"] != "admin") {
        redirect("home.php");
    }

    require("../PHP/config.php");
    require("../PHP/database.php");
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruoli da Accettare</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <!--NAVBAR-->
    <div id="navbar-container" data-navbar="navbar-logout-admin"></div>

    <h1>Role acception</h1>
    <div class="role-container">
        <?php
            $DB = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);

            $result = $DB->getDisabled();
            if ($result != false) {
                echo '<form action="accettazioneRuoli.php" method="POST">';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr><td>Email: '.$row["Email"].'</td><td>Ruolo: '.$row["Ruolo"].'</td><td><label for="accetta'.$row["ID"].'">Accetta</label><input type="checkbox" id="accetta'.$row["ID"].'"></td><td><label for="rifiuta'.$row["ID"].'">Rifiuta</label><input type="checkbox" id="rifiuta'.$row["ID"].'"></td></tr>';
                }
                echo '<button type="submit">Submit</button>';
                echo '</form>';
            } else {
                echo '<h3>Nessuna nuova richiesta</h3>';
            }
        ?>
    </div>
    

    <script src="../JS/navbar.js"></script>
</body>
</html>
