<?php
require_once '../PHP/config.php';
require_once '../PHP/database.php';

$article = null;

if (isset($_GET['idArticolo'])) {
    $idArticolo = intval($_GET['idArticolo']);

    $db = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT b.Title, b.Abstract, b.Data_Valutate, b.Data_Accettazione, b.ID_Utente, i.URL
    FROM Bozza b
    LEFT JOIN ImmaginiBozza ib ON b.ID = ib.ID_Bozza
    LEFT JOIN Immagini i ON i.ID = ib.ID_Immagine
    WHERE b.ID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $idArticolo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $article = $result->fetch_assoc();
        }
        $stmt->close();
    } else {
        error_log("Errore prepare statement in home.php: (" . $conn->errno . ") " . $conn->error);
    }

    $db->closeConnection();
}
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
                <p><strong>Data Valutazione:</strong> <?php echo htmlspecialchars($article['Data_Valutate'] ?? 'Non disponibile'); ?></p>
                <p><strong>Data Accettazione:</strong> <?php echo htmlspecialchars($article['Data_Accettazione'] ?? 'Non disponibile'); ?></p>
                <div>
                    <h3>Contenuto</h3>
                    <?php
                    $abstract = htmlspecialchars($article['Abstract']);
                    $abstract = str_replace("/N", "</p><p>", $abstract);
                    echo "<p>$abstract</p>";
                    ?>
                </div>
                <?php if (!empty($article['URL'])) { ?>
                    <div class="article-image">
                        <img src="<?php echo htmlspecialchars($article['URL']); ?>" alt="Immagine articolo" style="max-width: 100%; height: auto; border-radius: 12px; margin: 1em 0;">
                    </div>
                <?php } ?>
                <a href="home.php" class="back-link">Torna alla home</a>
            </div>
        <?php
        } else {
            session_start();

            if (isset($_SESSION["articoloContainer"])) {
                echo $_SESSION["articoloContainer"];
            } else {
                $db = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
                $latestArticle = $db->getUltimoArticoloApprovato();

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
                    $articoloContainer = <<<HTML
                        <div id="article-container">
                            <h1 id="scrittaReviewEffettiva">I Varani: Giganti Antichi tra Mito e Natura</h1>
                            <p id="testoReview1">Lorem ipsum dolor sit amet consectetur adipisicing elit...</p>
                            <img src="https://www.gannett-cdn.com/authoring/2011/01/27/NCOU/ghows-DA-7f3cea74-5a72-4ac7-99f5-2add0ccea1e0-b7824ad2.jpeg?crop=1886,1066,x0,y0&width=2560" alt="immagineVarano" id ="immagineVarano">
                            <br><br><br><br><br><br><br>
                            <hr>
                            <br><br><br>
                            <img src="https://www.gannett-cdn.com/authoring/2011/01/27/NCOU/ghows-DA-7f3cea74-5a72-4ac7-99f5-2add0ccea1e0-b7824ad2.jpeg?crop=1886,1066,x0,y0&width=2560" alt="immagineVarano2" id ="immagineVarano2">
                            <p id="testoReview2">Lorem vhnfkd,cbdfjkcvhnjrj,nvhkdnhjdchnsit amet consectetur adipisicing elit...</p>
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
