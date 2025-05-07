<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Articolo</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <div id="navbar-container" data-navbar="navbar-logout-WR"></div>

    <div class="container">
        <form action="../PHP/writerModificaArticolo.php" method="POST">
            <label for="id">ID articolo:</label>
            <input type="number" id="id" name="id" required>

            <label for="title">Titolo:</label>
            <input type="text" id="title" name="title" placeholder="Inserisci il titolo" required>

            <label for="abstract">Abstract:</label>
            <input type="text" id="abstract" name="abstract" placeholder="Inserisci l'abstract" required>

            <label for="text">Testo:</label>
            <textarea id="text" name="text" placeholder="Inserisci il testo completo" required></textarea>

            <button type="submit" class="btn">Modifica</button>
        </form>
    </div>

    <script src="../JS/navbar.js"></script>
</body>
</html>
