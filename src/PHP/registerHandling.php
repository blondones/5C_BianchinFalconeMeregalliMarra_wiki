<html>

    <body>
    
        <?php
        
        session_start();

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
        // Register Handling
        //

        
        $err=false;
        if(empty($_POST["email"]) || empty($_POST["password"])){
            $err=true;
        }else{
            $email=test_input($_POST["email"]);
            $pwd=test_input($_POST["password"]);
        }

        if (!$err) {
            
            

        }

        ?>

    </body>

</html>