<?php
session_start();
require_once '../PHP/config.php';
require_once '../PHP/database.php';

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$search_results = null;
$search_term = '';
$message = '';
$db = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['search'])) {
        $search_term = test_input($_POST['search']);

        try {
            $db = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
            $result_set = $db->getArticles($search_term);

            if ($result_set && $result_set->num_rows > 0) {
                $search_results = $result_set;
            } else {
                $search_results = false;
                $message = "Nessun articolo trovato corrispondente a: <strong>'" . htmlspecialchars($search_term) . "'</strong>";
            }
        } catch (Exception $e) {
            $message = "Errore durante la ricerca nel database: " . $e->getMessage();
            $search_results = false;
            if ($db) {
                $db->closeConnection();
            }
        }
    } else {
        $message = "Per favore, inserisci un termine di ricerca.";
        $search_results = false;
    }
} else {
    $message = "Effettua una ricerca dalla pagina principale per visualizzare i risultati.";
    $search_results = false;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risultati Ricerca Articoli</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <h1>Risultati della Ricerca</h1>

    <a href="home.php" class="back-button">Torna alla Home</a>

    <?php 
    if (!empty($message) && $search_results === false) {
        ?>
        <p class="message 
            <?php
            if (strpos(strtolower($message), 'errore') !== false) {
                echo 'error-message';
            } elseif (strpos(strtolower($message), 'nessun articolo') !== false) {
                echo 'no-results-message';
            }
            ?>">
            <?php echo $message; ?>
        </p>
        <?php
        if ($db && $search_results === false) {
            $db->closeConnection();
        }
    } elseif ($search_results) {
        ?>
        <p class="results-info">Articoli trovati per: <strong>"<?php echo htmlspecialchars($search_term); ?>"</strong></p>
        <table class="results-table">
            <thead>
                <tr>
                    <th>Titolo</th>
                    <th>Abstract (Anteprima)</th>
                    <th>Azione</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $search_results->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['Title']) . "</td>";
                    $abstract_preview = htmlspecialchars($row['Abstract']);
                    if (mb_strlen($abstract_preview) > 150) {
                        $abstract_preview = mb_substr($abstract_preview, 0, 150) . '...';
                    }
                    echo "<td>" . nl2br($abstract_preview) . "</td>";
                    echo "<td>
                            <form class='action-form' method='GET' action='home.php'>
                                <input type='hidden' name='idArticolo' value='" . htmlspecialchars($row['ID']) . "'>
                                <button type='submit'>Visualizza</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }

                if ($db) {
                    $db->closeConnection();
                }
                ?>
            </tbody>
        </table>
    <?php 
    }
    ?>
</body>
</html>
