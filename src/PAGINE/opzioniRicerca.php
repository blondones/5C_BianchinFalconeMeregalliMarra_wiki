<?php
    session_start();
    if(!isset($_SESSION['lista_articolo'])) {
        //formattazione della lista_articolo
        foreach($_SESSION['lista_articolo'] as $articolo) {

            echo "<tr><td>titolo: {$articolo['Title']}</td><td>contenuto: {$articolo['Abstract']}</td><td><a href='home.php?article_id=".$articolo['ID']."</td></tr>";
        }
    } else {
        redirect('home.php');
    }
?>