<?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'lab');

    function getDb() {
        //Create connection
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        return $conn;

        //Check connection
        if($conn->connect_error) {
            die("connection failed " . $conn->connect_error);
        }

    }
?>