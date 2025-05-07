<?php

    session_start();

    //
    // Import
    //

    require("config.php");
    require("database.php");

    function redirect($url)
    {
        header('Location: ' . $url);
        die();
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //
    // Register Handling
    //

    $err = false;
    
    if (empty($_POST["email"]) || empty($_POST["password"])) { //Forse mettere controllo su $_POST["writer"]/$_POST["reviewer"]
        
        $err = true;

    } else {

        $email = test_input($_POST["email"]);
        $pwd = test_input($_POST["password"]);
        $role = "";

        if (isset($_POST["writer"])) {
            $role = "writer";
        } else if (isset($_POST["reviewer"])) {
            $role = "reviewer";
        }
    }

    if (!$err) {
        
        $DB = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
        $DB->addUser($email, $pwd, $role);
        
        $adminInfo = $DB->getAdmin();
        $msg = "Hello Admin!\n There's a new User that would like to help in making your wiki even better!\n For more information go check the request on our site.\n";
        $msg = wordwrap($msg,70);
        mail($adminInfo["Email"], "New request!", $msg);
        
        redirect("../PAGINE/home.php");

    } else {

        redirect("../PAGINE/register.php");

    }
?>