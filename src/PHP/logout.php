
        <?php
            session_start();

            // remove all session variables
            echo session_unset();
            
            // destroy the session
            session_destroy();

            header('Location: ../PAGINE/home.php') ;
            exit;
        ?>