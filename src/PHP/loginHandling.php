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
                $row = $result->fetch_assoc();  
                $_SESSION["user_id"] = $row["ID"];
                echo "Utente trovato.."; 
                $DB->closeConnection();
                redirect("areapersonale.html"); 
            } else {
                echo "Utente non trovato. Riprovare..";
                $DB->closeConnection();
                redirect("/src/PAGINE/login.php");
            }

        } else {
            echo "Input non valido..";
            redirect("/src/PAGINE/login.php");
        }

    ?>

    </body>

</html>

