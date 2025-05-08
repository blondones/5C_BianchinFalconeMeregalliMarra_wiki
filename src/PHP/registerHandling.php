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

if (empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["confirm_password"])) {
    $err = true;

} elseif ($_POST["password"] !== $_POST["confirm_password"]) {
    $err = true; // ❗ Le password non corrispondono

} else {
    $email = test_input($_POST["email"]);
    $pwd = test_input($_POST["password"]);
    $role = "";

    if (isset($_POST["writer"])) {
        $role = "writer";
    } else if (isset($_POST["reviewer"])) {
        $role = "reviewer";
    } else {
        $err = true; // Nessun ruolo selezionato
    }
}


if (!$err) {

    $DB = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);

    // Se la registrazione fallisce (es. email già usata)
    if (!$DB->addUser($email, $pwd, $role)) {
        $err = true;
    } else {
        $adminInfo = $DB->getAdmin();
        $msg = "Hello Admin!\n There's a new User that would like to help in making your wiki even better!\n For more information go check the request on our site.\n";
        $msg = wordwrap($msg, 70);
        mail($adminInfo["Email"], "New request!", $msg);
        redirect("../PAGINE/home.php");
    }
}

// Se errore, torna alla pagina di registrazione
redirect("../PAGINE/register.php");

?>
