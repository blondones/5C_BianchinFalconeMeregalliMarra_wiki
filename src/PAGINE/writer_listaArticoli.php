<!-- listaArticoliBozze.php -->
<?php
require_once '../PHP/database.php';
require_once '../PHP/config.php';

$db = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
$conn = $db->getConnection();

$articoli = [];
$result = $db->getArticles("");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $articoli[] = $row;
    }
}

$db->closeConnection();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Articoli</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <div id="navbar-container" data-navbar="navbar-logout-WR"></div>

    <h1>Lista delle Bozze</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titolo</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($articoli)): ?>
                <?php foreach ($articoli as $articolo): ?>
                    <tr>
                        <td><?= htmlspecialchars($articolo['ID']) ?></td>
                        <td><?= htmlspecialchars($articolo['Title']) ?></td>
                        <td>
                            <form action="writerListaArticoli.php" method="POST" style="display:inline;">
                                <input type="hidden" name="articoloN" value="<?= $articolo['ID'] ?>">
                                <button type="submit" name="action" value="modify">Modifica</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Nessuna bozza trovata.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="create-new-container">
        <form action="../PAGINE/writer_creazioneArticolo.php" method="POST">
            <button type="submit">Crea Nuovo</button>
        </form>
    </div>

    <script src="../JS/navbar.js"></script>
</body>
</html>
