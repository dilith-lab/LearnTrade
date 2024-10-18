<?php
require_once __DIR__ . "/../config/config.inc.php";
class DBconn
{
    private $servername;
    private $username;
    private $password;
    private $dbname;


    protected function connect()
    {
        $this->servername = DB_SERVER;
        $this->username = DB_USERNAME;
        $this->password = DB_PASSWORD;
        $this->dbname = DB_DATABASE;

        try {
            $conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->dbname . ";", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed! - " . $e->getMessage() . "</br>";
            die();
        }
    }
}
