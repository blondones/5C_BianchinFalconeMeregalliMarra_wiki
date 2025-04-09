<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Area Personale</title>
        <link rel="stylesheet" href="../CSS/style.css">
    </head>
    <body>
        <?php 
            session_start();     


            function redirect($url) {
                header('Location: '.$url);
                die();
            }

            if (isset($_SESSION["user_id"])) {
                redirect("../PAGINE/login.php");
            } else {
        ?>

        <!--NAVBAR-->
        <div id="navbar-container" data-navbar="navbar-logout-<?php echo $_SESSION["user_role"]; ?>"></div>

        <h1 id="scrittaAreaPersonale">Benvenuto <?php echo $_SESSION["user_role"]; ?></h1> 

        <a href="../PHP/logout.php"> logout</a>

        <script src="../JS/navbar.js"></script>

        <?php
            }
        ?>
    </body>
</html>
