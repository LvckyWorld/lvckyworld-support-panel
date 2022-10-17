<?php
try {

    function getConnection(): PDO {

        $ip = "node03.lvckyworld.net";
        $dbname = "ticket_support";
        $username = "ticket_support";
        $password = "Tgw0o6*44";

        $conn = new PDO("mysql:host=$ip;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }

    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}