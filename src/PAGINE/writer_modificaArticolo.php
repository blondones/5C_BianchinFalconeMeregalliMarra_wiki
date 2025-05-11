<?php
session_start();
require_once '../PHP/config.php';
require_once '../PHP/database.php';

// Verifica parametro idArticolo
if (!isset($_GET['idArticolo'])) {
    header('Location: writer_listaArticoli.php');
    exit;
}
$id = intval($_GET['idArticolo']);

// Fetch dati bozza
$db = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
$conn = $db->getConnection();
$stmt = $conn->prepare("SELECT b.ID, b.Title, tb.Testo, b.Abstract
    FROM Bozza b
    JOIN TestoBozza tbz ON b.ID = tbz.ID_Bozza
    JOIN Testo tb ON tbz.ID_Testo = tb.ID
    WHERE b.ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $stmt->close();
    $db->closeConnection();
    die('Bozza non trovata.');
}
$articolo = $result->fetch_assoc();
$stmt->close();
$db->closeConnection();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Articolo</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <div id="navbar-container" data-navbar="navbar-logout-writer"></div>

    <div class="container">
        <h1>Modifica Bozza #<?= htmlspecialchars($articolo['ID']) ?></h1>
        <form action="../PHP/writerModificaArticolo.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($articolo['ID']) ?>">

            <label for="title">Titolo:</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($articolo['Title']) ?>" required>

            <label for="abstract">Abstract:</label>
            <textarea id="abstract" name="abstract" rows="3" required><?= htmlspecialchars($articolo['Abstract']) ?></textarea>

            <label for="text">Testo completo:</label>
            <textarea id="text" name="text" rows="10" required><?= htmlspecialchars($articolo['Testo']) ?></textarea>

            <button type="submit" class="btn">Salva Modifiche</button>
        </form>
    </div>

    <script src="../JS/navbar.js"></script>
</body>
</html>