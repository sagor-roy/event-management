<?php

namespace Config;

use PDO;
use PDOException;

class Database
{
    private $host = "localhost";
    private $db_name = "jewellery";
    private $username = "root";
    private $password = "plzletme!n";

    public function connect(): PDO
    {
        try {
            $pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            return $pdo;
        } catch (PDOException $e) {
            throw new \Exception("Database connection failed: " . $e->getMessage());
        }
    }
}
