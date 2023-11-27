<?php

    $dsn = 'mysql:host=localhost;dbname=two_proteins';

    $user = "root";
    $pass = "";
    $dbname = "two_proteins";

    // $con = mysqli_connect("localhost", $user, $pass, $dbname);

    // if (!$con) {
    //     die("connection no bueno");
    // }

    try {
        $db = new PDO($dsn, $user);
    } catch (PDOException $e) {
        $error_message = 'Database Error: ';
        $error_message .= $e->getMessage();
        echo $error_message;
        exit();
    }

?>