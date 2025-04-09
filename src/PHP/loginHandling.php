<html>

    <body>
    
    <?php

        session_start();    

        //
        // Import
        //
        
        require("config.php");
        require("database.php");

        //
        // Functions
        //
        
        function redirect($url) {
            header('Location: '.$url);
            die();
        }
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        //
        // Login Handling
        //

        
        $err=false;
        if(empty($_POST["email"]) || empty($_POST["password"])){
            $err=true;
        }else{
            $email=test_input($_POST["email"]);
            $pwd=test_input($_POST["password"]);
        }

        //
        // Check Credentials
        //

        if (!$err) {

            $DB = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);

            $result = $DB->checkUser($email, $pwd);

            if($result != false) {
                if ($result["Stato"] == 1) {
                    echo "Login effettuato..";
                    $_SESSION["user_id"] = $result["ID"];
                    $_SESSION["user_role"] = $result["Ruolo"];
                    redirect("../PAGINE/areapersonale.php");
                } else {
                    echo "Utente non abilitato..";
                    redirect("../PAGINE/login.php");
                } 
            } else {
                echo "Utente non trovato. Riprovare..";
                $DB->closeConnection();
                redirect("../PAGINE/login.php");
            }
        } else {
            echo "Input non valido..";
            redirect("../PAGINE/login.php");
        }

    ?>

    </body>

</html>

