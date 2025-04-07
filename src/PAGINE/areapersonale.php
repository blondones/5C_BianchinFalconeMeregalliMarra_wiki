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
    ?>

    <!--NAVBAR-->
    <div id="navbar-container" data-navbar="navbar-logout-<?php echo $_SESSION["user_role"]; ?>"></div>

    <h1 id="scrittaAreaPersonale">Benvenuto <?php echo $_SESSION["user_role"]; ?></h1> 

    <a href="../PHP/logout.php"> logout</a>

    <script src="../JS/navbar.js"></script>
</body>
</html>
