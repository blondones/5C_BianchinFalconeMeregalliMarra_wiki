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
    function debug_to_console($data)
    {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
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
    // Login Handling
    //


    $err = false;
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        $err = true;
    } else {
        $email = test_input($_POST["email"]);
        $pwd = test_input($_POST["password"]);
    }

    //
    // Check Credentials
    //

    if (!$err) {

        $DB = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);

        $result = $DB->checkUser($email, $pwd);

        if ($result != false) {
            if ($result["Stato"] == 1) {
                $_SESSION["user_id"] = $result["ID"];
                $_SESSION["user_role"] = $result["Ruolo"];
                redirect("../PAGINE/areapersonale.php");
            } else {
                redirect("../PAGINE/login.php");
            }
        } else {
            redirect("../PAGINE/login.php");
        }
    } else {
        redirect("../PAGINE/login.php");
    }

?>