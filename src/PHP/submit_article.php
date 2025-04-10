<?php
require_once 'config.php';

$conn = new mysqli($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
if ($conn->connect_error) {
    die("Errore di connessione: " . $conn->connect_error);
}

$id_utente = 1;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'] ?? '';
    $abstract = $_POST['abstract'] ?? '';
    $text = $_POST['text'] ?? '';
    $images = $_POST['images'] ?? '';

    $sql_testo = "INSERT INTO Testo (Testo) VALUES (?)";
    $stmt_testo = $conn->prepare($sql_testo);
    $stmt_testo->bind_param("s", $text);

    if ($stmt_testo->execute()) {
        $id_testo = $stmt_testo->insert_id;

        $sql_bozza = "INSERT INTO Bozza (ID_Utente, Title, Abstract) VALUES (?, ?, ?)";
        $stmt_bozza = $conn->prepare($sql_bozza);
        $stmt_bozza->bind_param("iss", $id_utente, $title, $abstract);

        if ($stmt_bozza->execute()) {
            $id_bozza = $stmt_bozza->insert_id;

            $sql_associar_testo = "INSERT INTO TestoBozza (ID_Bozza, ID_Testo) VALUES (?, ?)";
            $stmt_associar_testo = $conn->prepare($sql_associar_testo);
            $stmt_associar_testo->bind_param("ii", $id_bozza, $id_testo);

            if ($stmt_associar_testo->execute()) {
                $img_urls = explode(',', $images);
                $sql_img = "INSERT INTO Immagini (URL) VALUES (?)";
                $stmt_img = $conn->prepare($sql_img);

                foreach ($img_urls as $url) {
                    $url = trim($url);
                    if (!empty($url)) {
                        $stmt_img->bind_param("s", $url);
                        $stmt_img->execute();

                        $id_img = $stmt_img->insert_id;
                        $sql_associate_img = "INSERT INTO ImmaginiBozza (ID_Bozza, ID_Immagine) VALUES (?, ?)";
                        $stmt_associate_img = $conn->prepare($sql_associate_img);
                        $stmt_associate_img->bind_param("ii", $id_bozza, $id_img);
                        $stmt_associate_img->execute();
                    }
                }

                echo "Bozza salvata con successo!";
            } else {
                echo "Errore durante l'associazione del testo alla bozza: " . $stmt_associar_testo->error;
            }
        } else {
            echo "Errore durante l'inserimento della bozza: " . $stmt_bozza->error;
        }
    } else {
        echo "Errore durante l'inserimento del testo: " . $stmt_testo->error;
    }
}

$conn->close();
?>
