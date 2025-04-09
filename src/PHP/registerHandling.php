<?php

    session_start();

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
        } else {
            $role = "reviewer";
        }
    }

    if (!$err) {

        $DB = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);
        $DB->addUser($email, $pwd, $role);

        redirect("../PAGINE/home.php");

    } else {

        redirect("../PAGINE/register.php");

    }

?>