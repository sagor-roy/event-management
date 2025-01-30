<?php

namespace App\Model;

use Config\Database;
use PDO;
use PDOException;

class Event extends Database
{
    private string $table_name = "events";

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
            $query = "INSERT INTO $this->table_name (name, slug, description, date, location, max_capacity, status, created_by) 
                      VALUES (:name, :slug, :description, :date, :location, :max_capacity, :status, :created_by)";

            $stmt = $this->connect()->prepare($query);

            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':slug', $data['slug']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':date', $data['date']);
            $stmt->bindParam(':location', $data['location']);
            $stmt->bindParam(':max_capacity', $data['max_capacity']);
            $stmt->bindParam(':status', $data['status']);
            $stmt->bindParam(':created_by', $data['created_by']);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new \Exception("User creation failed: " . $e->getMessage());
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
            $query = "UPDATE $this->table_name 
                  SET name = :name, slug = :slug, description = :description, 
                      date = :date, location = :location, max_capacity = :max_capacity, 
                      status = :status, created_by = :created_by 
                  WHERE id = :id";

            $stmt = $this->connect()->prepare($query);

            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':slug', $data['slug']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':date', $data['date']);
            $stmt->bindParam(':location', $data['location']);
            $stmt->bindParam(':max_capacity', $data['max_capacity']);
            $stmt->bindParam(':status', $data['status']);
            $stmt->bindParam(':created_by', $data['created_by']);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new \Exception("Event update failed: " . $e->getMessage());
        }
    }

    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM $this->table_name WHERE id = :id";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new \Exception("Event deletion failed: " . $e->getMessage());
        }
    }
    

    public function paginate(int $perPage = 10, int $page = 1): array
    {
        try {
            $offset = ($page - 1) * $perPage;
            $query = "SELECT 
                        e.id, e.name, e.slug, e.description, e.date, e.location, 
                        e.max_capacity, e.status, e.created_by, u.name AS created_by_name, 
                        e.created_at, e.updated_at,
                        (e.max_capacity - COALESCE(a.attendee_count, 0)) AS remaining_tickets
                      FROM $this->table_name e
                      LEFT JOIN (
                          SELECT event_id, COUNT(*) AS attendee_count 
                          FROM attendees 
                          GROUP BY event_id
                      ) a ON e.id = a.event_id
                      LEFT JOIN users u ON e.created_by = u.id
                      ORDER BY e.id DESC
                      LIMIT :perPage OFFSET :offset";

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
