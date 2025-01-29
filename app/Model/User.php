<?php

namespace App\Model;

use Config\Database;
use PDO;
use PDOException;

class User extends Database
{
    private string $table_name = "users";
    private int $id = 2;

    public function read(): array|false
    {
        try {
            $query = "SELECT * FROM $this->table_name WHERE id = :id";
            $stmt = $this->connect()->prepare($query);
            $id = 2;
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception("Data fetching failed: " . $e->getMessage());
        }
    }
}
