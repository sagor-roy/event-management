<?php

namespace App\Model;

use Config\Database;
use PDO;
use PDOException;

class User extends Database
{
    private string $table_name = "users";

    public function getAll(): array|false
    {
        try {
            $query = "SELECT * FROM $this->table_name";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception("Data fetching failed: " . $e->getMessage());
        }
    }

    public function getFirst(string $column, string $operator, mixed $value): array|false
    {
        try {
            $allowedOperators = ['=', '!=', '<', '>', '<=', '>=', 'LIKE'];
            if (!in_array($operator, $allowedOperators)) {
                throw new \InvalidArgumentException("Invalid operator: $operator");
            }

            $query = "SELECT * FROM $this->table_name WHERE $column $operator :value LIMIT 1";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(":value", $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception("Data fetching failed: " . $e->getMessage());
        }
    }

    public function create(array $data): bool
    {
        try {
            $query = "INSERT INTO $this->table_name (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $this->connect()->prepare($query);

            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $data['password']);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new \Exception("User creation failed: " . $e->getMessage());
        }
    }

    public function paginate(int $perPage = 10, int $page = 1): array
    {
        try {
            $offset = ($page - 1) * $perPage;
            $query = "SELECT id,name,email FROM $this->table_name ORDER BY id DESC LIMIT :perPage OFFSET :offset";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception("Pagination failed: " . $e->getMessage());
        }
    }

    public function count(): int
    {
        try {
            $query = "SELECT COUNT(*) as total FROM $this->table_name";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            throw new \Exception("Counting users failed: " . $e->getMessage());
        }
    }
}
