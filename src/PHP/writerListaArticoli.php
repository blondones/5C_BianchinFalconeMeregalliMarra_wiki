<?php
require_once 'config.php';
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'modify') {
    $id = intval($_POST['articoloN']);

    $db = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
    $bozza = $db->getBozzaById($id);
    $db->closeConnection();

    if ($bozza) {
        ?>
        <!DOCTYPE html>
        <html lang="it">
        <head>
            <meta charset="UTF-8">
            <title>Modifica Articolo</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <h1>Modifica Bozza</h1>
            <form action="salvaModificaBozza.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($bozza['ID']) ?>">
                <label>Titolo: <input type="text" name="title" value="<?= htmlspecialchars($bozza['Title']) ?>"></label><br>
                <label>Abstract:<br>
                    <textarea name="abstract" rows="5" cols="60"><?= htmlspecialchars($bozza['Abstract']) ?></textarea>
                </label><br>
                <label>Testo completo:<br>
                    <textarea name="text" rows="10" cols="80"><?= htmlspecialchars($bozza['Text']) ?></textarea>
                </label><br>
                <button type="submit">Salva Modifiche</button>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Bozza non trovata.";
    }
} else {
    echo "Richiesta non valida.";
}
?>
