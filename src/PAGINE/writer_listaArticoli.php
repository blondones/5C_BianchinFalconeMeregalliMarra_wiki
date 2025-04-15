<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>listaArticoliBozze</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <!--NAVBAR-->
    <div id="navbar-container" data-navbar="navbar-logout-WR"></div>

    <h1>Article List</h1>

    <form action="writerListaArticoli.php" method="POST">
        <div class="role-container">
            <div class="role-info">
                <label for="articoloN">Articolo N</label>
                <input type="text" id="articoloN" name="articoloN" required>
            </div>
            <div class="role-buttons">
                <button type="submit" name="action" value="modify">Modify</button>
            </div>
        </div>
    </form>

    <!-- Bottone Create New in basso al centro -->
    <div class="create-new-container">
        <form action="writerListaArticoli.php" method="POST">
            <button type="submit">Create New</button>
        </form>
    </div>

    <script src="../JS/navbar.js"></script>
</body>
</html>
