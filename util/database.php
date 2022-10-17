<?php
try {

    function getConnection(): PDO {

        $ip = "localhost";
        $dbname = "ticketsystem";
        $username = "root";
        $password = "12345";

        $conn = new PDO("mysql:host=$ip;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }

    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}