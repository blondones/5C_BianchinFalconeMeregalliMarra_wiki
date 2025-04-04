<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="../CSS/style.css">

</head>
<body>
    <!--NAVBAR-->
    <div id="navbar-container" data-navbar="navbar-empty"></div>

    <!--REGISTER-->
    <div id="register-container">
        <h1>REGISTER</h1>
        <form id="formRegister" action="" method="POST">
            <input type="email" class="inputLogin" id="email" placeholder="Inserisci la tua email" required> <!-- inserimento email -->
            <input type="password" class="inputLogin" id="password" placeholder="Inserisci la tua password" required> <!-- inserimento password -->
            <input type="password" class="inputLogin" id="confermaPassword" placeholder="Conferma la tua password" required> <!-- conferma password -->
            <button id="bottoneWriter" type="submit">Register as Writer</button>
            <button id="bottoneRegister" type="submit">Register as Reviewer</button>
        </form>

    </div>


    <script src="../JS/navbar.js"></script>
</body>
</html>