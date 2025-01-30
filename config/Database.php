<?php

namespace Config;

use PDO;
use PDOException;

class Database
{
    private $host;
    private $db;
    private $user;
    private $pass;

    public function __construct()
    {
        $this->host = env('DB_HOST');
        $this->db = env('DB_NAME');
        $this->user = env('DB_USER');
        $this->pass = env('DB_PASS');
    }

    public function connect(): PDO
    {
        try {
            $pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->db}",
                $this->user,
                $this->pass,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            return $pdo;
        } catch (PDOException $e) {
            throw new \Exception("Database connection failed: " . $e->getMessage());
        }
    }
}
