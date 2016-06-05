<?php


class DBConnect{
    static private $dbName = "school";
    static private $dbUser = "root";
    static private $dbPassword = "coderslab";
    static private $dbHost = "localhost";

    static public function createConnection(){
        $conn = new mysqli(self::$dbHost,
                           self::$dbUser,
                           self::$dbPassword,
                           self::$dbName);
        if($conn->connect_errno !== 0){
            die($conn->connect_error);
        }
        return $conn;
    }

    private function __construct(){
    }
}