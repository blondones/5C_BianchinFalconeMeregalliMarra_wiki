<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>
    <!--NAVBAR-->
    <div id="navbar-container"></div>
    
    <?php
        session_start();
        if (isset($_SESSION["user_id"])) {
            echo "Già loggato.."; 
            redirect("areapersonale.html");
        } else {
    ?>

    <!--LOGIN-->
    <div id="loginContainer">
        <h1>LOGIN</h1>
        <form id="formLogin" action="/src/PHP/loginHandling.php" method="POST">
            <label for="email" class="scrittaLogin">email</p>
            <input type="text" class="inputLogin" id="email" name="email" placeholder="Inserisci la tua email" required>
            <label for= "password" class="scrittaLogin">password</p>
            <input type="password" class="inputLogin" id="password" name="password" placeholder="Inserisci la tua password" required>
            <button id="bottoneLogin" type="submit">Login</button>
        </form>
        <p id="scrittaRegister">Vuoi Aiutarci? Clicca <a href="DAINSERIRE.html">qui!</a></p>
    </div>

    <?php
        }
    ?>

    <script src="../JS/navbar.js"></script>
</body>
</html>
