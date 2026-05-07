<?php

class Database {
    protected $conn;

    public function __construct() {
        $this->connect();
    }

    protected function connect() {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db   = "uts";

        $this->conn = new mysqli($host, $user, $pass, $db);
        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8");
    }

    public function getConnection() {
        return $this->conn;
    }
}

?>