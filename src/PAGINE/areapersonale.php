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
        require("../PHP/config.php");
        require("../PHP/database.php");
    ?>

    <!--NAVBAR-->
    <div id="navbar-container" data-navbar=""></div>

    <h1 id="scrittaAreaPersonale">Benvenuto <?php 
        $DB = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
        $result = $DB->getRole($_SESSION["user_id"]);
        print_r($result->fetch_assoc()["Ruolo"]);
        $DB->closeConnection();
    ?></h1> 

    <a href="../PHP/logout.php"> logout</a>

    <script src="../JS/navbar.js"></script>
</body>
</html>
