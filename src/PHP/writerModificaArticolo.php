<?php
session_start();
require_once 'config.php';
require_once 'Database.php';

$db = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'], $_POST['title'], $_POST['abstract'], $_POST['text'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $abstract = $_POST['abstract'];
        $text = $_POST['text'];

        $stmt1 = $conn->prepare("UPDATE Bozza SET Title = ?, Abstract = ? WHERE ID = ?");
        $stmt1->bind_param("ssi", $title, $abstract, $id);
        $result1 = $stmt1->execute();
        $stmt1->close();

        $stmt2 = $conn->prepare("SELECT ID_Testo FROM TestoBozza WHERE ID_Bozza = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $res = $stmt2->get_result();
        $stmt2->close();

        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $idTesto = $row['ID_Testo'];

            $stmt3 = $conn->prepare("UPDATE Testo SET Testo = ? WHERE ID = ?");
            $stmt3->bind_param("si", $text, $idTesto);
            $result3 = $stmt3->execute();
            $stmt3->close();

            if ($result1 && $result3) {
                echo "Articolo modificato con successo.";
                echo '<form action="..//PAGINE/writer_listaArticoli.php" method="get">
                        <button type="submit">Torna alla lista delle bozze</button>
                    </form>';

            } else {
                echo "Errore nella modifica dell'articolo.";
            }
        } else {
            echo "Articolo non trovato o senza testo associato.";
        }
    } else {
        echo "Dati mancanti nel form.";
    }
}

$db->closeConnection();
?>
