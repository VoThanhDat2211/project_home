<?php
    $servername="localhost";
    $usernameDB="root";
    $passwordDB= "";
    $dbname= "project_php";

    $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);
    if ($conn->connect_error) {
        die("connection failed!". $conn->connect_error);
    }
?>