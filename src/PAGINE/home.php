<?php
require_once '../PHP/config.php';
require_once '../PHP/database.php';

// Inizializza $article a null o un valore di default
$article = null;

if (isset($_GET['idArticolo'])) {
    $idArticolo = intval($_GET['idArticolo']);

    // Crea l'oggetto Database e ottieni la connessione
    $db = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
    $conn = $db->getConnection(); // Assumendo che questo metodo restituisca la connessione mysqli

    // Prepara la query per fetchare l'articolo specifico
    // Assicurati che i nomi delle colonne (Title, Abstract, etc.) e della tabella (Bozza) siano corretti
    $stmt = $conn->prepare("SELECT Title, Abstract, Data_Valutate, Data_Accettazione, ID_Utente FROM Bozza WHERE ID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $idArticolo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $article = $result->fetch_assoc(); // Prende i dati dell'articolo
        }
        // else { $article rimane null, verrà mostrato il contenuto di default }
        $stmt->close();
    } else {
        // Logga l'errore se la preparazione fallisce  ok quindi è stato falcone
        error_log("Errore prepare statement in home.php: (" . $conn->errno . ") " . $conn->error);
    }

    // Chiudi la connessione al database
    $db->closeConnection();
}
// Se non c'è article_id, $article rimane null e verrà mostrato il contenuto di default
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Home - Portale Articoli</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>

    <div id="navbar-container" data-navbar="navbar-search-user"></div>

    <h1>Home</h1>

    <hr>

    <div class="content-area">
        <?php
        if ($article) {
        ?>
            <div class="article-container">
                <h2><?php echo htmlspecialchars($article['Title']); ?></h2>
                <p><strong>ID Utente:</strong> <?php echo htmlspecialchars($article['ID_Utente']); ?></p>
                <p><strong>Data Valutazione:</strong> <?php echo htmlspecialchars($article['Data_Valutate'] ?? 'Non disponibile'); ?></p>
                <p><strong>Data Accettazione:</strong> <?php echo htmlspecialchars($article['Data_Accettazione'] ?? 'Non disponibile'); ?></p>
                <div>
                    <h3>Abstract</h3>
                    <p><?php echo nl2br(htmlspecialchars($article['Abstract'])); ?></p>
                </div>
                <a href="home.php" class="back-link">Torna alla ricerca</a>
            </div>
        <?php
        } else {
            session_start();

            if (isset($_SESSION["articoloContainer"])) {
                echo $_SESSION["articoloContainer"];
                
            } else {
                // Otherwise, fetch the most recently approved article
                $db = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
                $latestArticle = $db->getUltimoArticoloApprovato(); // Create this method

                if ($latestArticle) {
                    $title = htmlspecialchars($latestArticle['Title']);
                    $abstract = nl2br(htmlspecialchars($latestArticle['Abstract']));
                    $text = nl2br(htmlspecialchars($latestArticle['Text']));

                    $articoloContainer = <<<HTML
                                <div id="article-container">
                                    <h1 id="scrittaReviewEffettiva">{$title}</h1>
                                    <p id="testoReview1">{$abstract}</p>
                                    <img src="https://www.gannett-cdn.com/authoring/2011/01/27/NCOU/ghows-DA-7f3cea74-5a72-4ac7-99f5-2add0ccea1e0-b7824ad2.jpeg?crop=1886,1066,x0,y0&width=2560" alt="immagineVarano" id="immagineVarano">
                                    <br><br><br><br><br><br><br>
                                    <hr>
                                    <br><br><br>
                                    <img src="https://www.gannett-cdn.com/authoring/2011/01/27/NCOU/ghows-DA-7f3cea74-5a72-4ac7-99f5-2add0ccea1e0-b7824ad2.jpeg?crop=1886,1066,x0,y0&width=2560" alt="immagineVarano2" id="immagineVarano2">
                                    <p id="testoReview2">{$text}</p>
                                </div>
                                HTML;

                    echo $articoloContainer;
                } else {
                    // ritorno all articolo default
                    $articoloContainer = <<<HTML
                                <div id="article-container">
                                    <h1 id="scrittaReviewEffettiva">I Varani: Giganti Antichi tra Mito e Natura</h1>
                                    <p id="testoReview1">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat ullam vel ipsam excepturi quam ad, quae error omnis ea, aut repellat at voluptatem nam. Optio placeat natus quibusdam rem fuga.</p>
                                    <img src="https://www.gannett-cdn.com/authoring/2011/01/27/NCOU/ghows-DA-7f3cea74-5a72-4ac7-99f5-2add0ccea1e0-b7824ad2.jpeg?crop=1886,1066,x0,y0&width=2560" alt="immagineVarano" id ="immagineVarano">
                                    <br><br><br><br><br><br><br>
                                    <hr>
                                    <br><br><br>
                                    <img src="https://www.gannett-cdn.com/authoring/2011/01/27/NCOU/ghows-DA-7f3cea74-5a72-4ac7-99f5-2add0ccea1e0-b7824ad2.jpeg?crop=1886,1066,x0,y0&width=2560" alt="immagineVarano2" id ="immagineVarano2">
                                    <p id="testoReview2">Lorem vhnfkd,cbdfjkcvhnjrj,nvhkdnhjdchnsit amet consectetur adipisicing elit. Ipsum ratione dicta facilis deleniti in consequuntur laudantium consequatur quae. Unde animi voluptatum ad architecto nesciunt! Molestiae explicabo dicta eveniet cum perferendis.</p>
                                </div>
                                HTML;
                    echo $articoloContainer;
                }
            }
        }
        ?>

    </div>

    <script src="../JS/navbar.js"></script>
</body>

</html>