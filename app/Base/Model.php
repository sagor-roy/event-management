<?php

namespace App\Base;

class Model
{
    protected static string $tableName;
    private $host;
    private $db;
    private $user;
    private $pass;
    private $getQuery;

    public function __construct()
    {
        $this->host = env('DB_HOST');
        $this->db = env('DB_NAME');
        $this->user = env('DB_USER');
        $this->pass = env('DB_PASS');
        $this->getQuery = "SELECT * FROM " . static::$tableName;
    }

    // Get the table name
    public static function getTableName()
    {
        return static::$tableName;
    }

    // DB Connection
    public function connect()
    {
        try {
            return new \PDO(
                "mysql:host={$this->host};dbname={$this->db}",
                $this->user,
                $this->pass
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function where(...$conditions)
    {
        if (count($conditions) === 2) {
            list($column, $value) = $conditions;
            $this->getQuery .= " WHERE {$column} = " . $this->connect()->quote($value);
        } elseif (count($conditions) === 3) {
            list($column, $operator, $value) = $conditions;
            $this->getQuery .= " WHERE {$column} {$operator} " . $this->connect()->quote($value);
        } else {
            throw new \InvalidArgumentException('Invalid number of parameters for WHERE clause');
        }

        return $this;
    }

    // Fetch all data from Database
    public function get(): array|false
    {
        if (empty($this->getQuery)) {
            throw new \LogicException('Query is empty. Cannot execute fetch operation.');
        }

        return $this->fetch($this->getQuery);
    }

    // Store data
    public function create(array $data)
    {
        $columns = implode('`, `', array_keys($data));
        $values = implode(', ', array_map(fn($val) => $this->connect()->quote($val), array_values($data)));

        $query = "INSERT INTO `{$this->getTableName()}` (`{$columns}`) VALUES ({$values})";
        $this->execute($query);
    }

    // Get single record by ID
    public function find(int|string $mixed_string)
    {
        preg_match_all('/\d+/', $mixed_string, $matches);
        $id = implode("", $matches[0]);
        $query = "SELECT * FROM {$this->getTableName()} WHERE id={$id}";
        $result = $this->fetch($query);

        return $result;
    }

    // Update data
    public function update($id, $data)
    {
        $values = implode(', ', array_map(
            fn($key, $val) => "`{$key}` = " . $this->connect()->quote($val),
            array_keys($data),
            array_values($data)
        ));

        $query = "UPDATE {$this->getTableName()} SET {$values} WHERE id={$id}";
        $this->execute($query);
    }

    // Delete data
    public function delete(int|string $id): \PDOStatement|false
    {
        $query = "DELETE FROM {$this->getTableName()} WHERE id={$id}";
        return $this->execute($query);
    }

    // Execute query
    public function execute($query): \PDOStatement|false
    {
        if (empty($query)) {
            throw new \InvalidArgumentException('Query cannot be empty.');
        }

        $pdo = $this->connect();
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Fetch data
    public function fetch($query): array|false
    {
        if (empty($query)) {
            throw new \InvalidArgumentException('Query cannot be empty.');
        }

        $stmt = $this->execute($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
