<?php
require_once '../PHP/database.php';
require_once '../PHP/config.php';

$db = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
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
    <div id="navbar-container" data-navbar="navbar-logout-writer"></div>

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
            <?php
            if (!empty($articoli)) {
                foreach ($articoli as $articolo) {
            ?>
                    <tr>
                        <td><?php echo htmlspecialchars($articolo['ID']); ?></td>
                        <td><?php echo htmlspecialchars($articolo['Title']); ?></td>
                        <td>
                            <form action="writer_modificaArticolo.php" method="GET" style="display:inline;">
                                <input type="hidden" name="idArticolo" value="<?php echo $articolo['ID']; ?>">
                                <button type="submit">Modifica</button>
                            </form>
                        </td>
                    </tr>
            <?php
                } // end foreach
            } else {
            ?>
                <tr>
                    <td colspan="3">Nessuna bozza trovata.</td>
                </tr>
            <?php
            } // end if
            ?>
        </tbody>
    </table>

    <div class="create-new-container">
        <form action="writer_creazioneArticolo.php" method="GET">
            <button type="submit">Crea Nuovo</button>
        </form>
    </div>

    <script src="../JS/navbar.js"></script>
</body>
</html>
