<?php
session_start();


if (isset($_SESSION["email"]) && isset($_SESSION["password"])) {
    $login["email"] = $_SESSION["email"];
    $login["password"] = $_SESSION["password"];
} else {
    $login = array();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        echo "Dati vuoti";
        exit();
    } else {
        function test_input($data) {
            return trim(htmlspecialchars($data, ENT_QUOTES, 'UTF-8'));
        }


        $pwr = test_input($_POST["password"]);
        $email = test_input($_POST["email"]);


        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "L'email non è valida!";
            exit();
        }


        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "wiki";


        $connection = new mysqli($host, $username, $password, $dbname);


        if ($connection->connect_error) {
            die("Connessione fallita: " . $connection->connect_error);
        }


        $statement = $connection->prepare("SELECT * FROM utente WHERE email = ? AND password = ?");
        $statement->bind_param("ss", $email, $pwr);
        $statement->execute();
        $result = $statement->get_result();


        if ($result->num_rows != 1) {
            echo "Utente non valido";
            exit();
        }


        $_SESSION["email"] = $email;
        $_SESSION["password"] = $pwr;


        echo "Login riuscito!";
    }
} else {
}
