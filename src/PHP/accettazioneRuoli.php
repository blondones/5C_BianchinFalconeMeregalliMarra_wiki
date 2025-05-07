<?php

session_start();

function redirect($url){
    header('Location: ' . $url);
    die();
}

require("config.php");
require("database.php");

$DB = new Database($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);

for ($i = $DB->getMinUser(); $i <= $DB->getMaxUser(); $i++) {

    $curr_usr_accept = "accetta".$i;
    $curr_usr_reject = "rifiuta".$i;

    if (isset($_POST[$curr_usr_accept])) {
        $DB->changeUserStatus(true, $i);
    } else if (isset($_POST[$curr_usr_reject])) {
        $DB->deleteUser($i);
    }

    
}

redirect("../PAGINE/admin_ruoliAccettare.php");

?>