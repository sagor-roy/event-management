<?php

namespace App\Base;

use PDO;
use PDOException;

class Model
{
    protected static string $tableName;
    private $host;
    private $db;
    private $user;
    private $pass;
    private $query;
    private $params = [];

    public function __construct()
    {
        $this->host = env('DB_HOST');
        $this->db = env('DB_NAME');
        $this->user = env('DB_USER');
        $this->pass = env('DB_PASS');
        $this->query = "SELECT * FROM " . static::$tableName;
    }

    // Get the table name
    public static function getTableName(): string
    {
        return static::$tableName;
    }

    // DB Connection
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

    // Add WHERE clause with parameter binding
    public function where(string $column, string $operator, mixed $value): static
    {
        $this->query .= (stripos($this->query, 'WHERE') !== false ? " AND" : " WHERE") . " `{$column}` {$operator} ?";
        $this->params[] = $value;
        return $this;
    }

    // Fetch all data
    public function get(): array|false
    {
        return $this->fetch($this->query, $this->params);
    }

    // Create new record
    public function create(array $data): bool
    {
        $columns = implode('`, `', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $query = "INSERT INTO `{$this->getTableName()}` (`{$columns}`) VALUES ({$placeholders})";
        return $this->execute($query, array_values($data));
    }

    // Find a single record by ID
    public function find(int|string $id): array|false
    {
        $query = "SELECT * FROM `{$this->getTableName()}` WHERE `id` = ?";
        return $this->fetch($query, [$id]);
    }

    // Update a record by ID
    public function update(int|string $id, array $data): bool
    {
        $setClause = implode(', ', array_map(fn($key) => "`{$key}` = ?", array_keys($data)));

        $query = "UPDATE `{$this->getTableName()}` SET {$setClause} WHERE `id` = ?";
        $params = array_merge(array_values($data), [$id]);

        return $this->execute($query, $params);
    }

    // Delete a record by ID
    public function delete(int|string $id): bool
    {
        $query = "DELETE FROM `{$this->getTableName()}` WHERE `id` = ?";
        return $this->execute($query, [$id]);
    }

    // Execute a query with parameters
    public function execute(string $query, array $params = []): bool
    {
        try {
            $stmt = $this->connect()->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            throw new \Exception("Query execution failed: " . $e->getMessage());
        }
    }

    // Fetch results from a query
    public function fetch(string $query, array $params = []): array|false
    {
        try {
            $stmt = $this->connect()->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception("Data fetching failed: " . $e->getMessage());
        }
    }
}
