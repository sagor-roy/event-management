<?php

namespace App\Model;

use Config\Database;
use PDO;
use PDOException;

class Event extends Database
{
    private string $table_name = "events";

    /**
     * Fetches all events from the database.
     * 
     * @return array|false Returns an associative array of all events or false if no events are found.
     * @throws \Exception If data fetching fails.
     */
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

    /**
     * Fetches the first event that matches the given column, operator, and value.
     * 
     * @param string $column The column to filter by.
     * @param string $operator The operator to use for comparison (e.g., '=', '!=', '<', '>', 'LIKE').
     * @param mixed $value The value to compare against.
     * @return array|false Returns an associative array of the first matching event or false if no match is found.
     * @throws \InvalidArgumentException If the operator is invalid.
     * @throws \Exception If data fetching fails.
     */
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
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result : false;
        } catch (PDOException $e) {
            throw new \Exception("Data fetching failed: " . $e->getMessage());
        }
    }

    /**
     * Retrieves event details and calculates remaining tickets for a given event ID.
     *
     * @param string|int $event_id The ID of the event.
     * @return array|false Associative array with event details and `remaining_tickets`, or `false` if not found.
     * @throws \Exception If a database error occurs.
     */
    public function checkCapacity(string|int $event_id): array|false
    {
        try {
            $query = "SELECT 
            e.id, e.name, e.slug, e.description, e.date, e.location, 
            e.max_capacity, e.status, e.created_by, u.name AS created_by_name, 
            e.created_at, e.updated_at,
            (e.max_capacity - COALESCE(a.attendee_count, 0)) AS remaining_tickets
        FROM {$this->table_name} e
        LEFT JOIN (
            SELECT event_id, COUNT(*) AS attendee_count 
            FROM attendees 
            GROUP BY event_id
        ) a ON e.id = a.event_id
        LEFT JOIN users u ON e.created_by = u.id
        WHERE e.id = :event_id";

            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(':event_id', $event_id, is_int($event_id) ? PDO::PARAM_INT : PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result : false;
        } catch (PDOException $e) {
            throw new \Exception("Failed to check event capacity: " . $e->getMessage());
        }
    }

    /**
     * Creates a new event in the database.
     * 
     * @param array $data An associative array containing event data (name, slug, description, date, location, max_capacity, status, created_by).
     * @return bool Returns true if the event is successfully created.
     * @throws \Exception If event creation fails.
     */
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

    /**
     * Updates an existing event in the database.
     * 
     * @param int $id The ID of the event to update.
     * @param array $data An associative array containing updated event data (name, slug, description, date, location, max_capacity, status, created_by).
     * @return bool Returns true if the event is successfully updated.
     * @throws \Exception If event update fails.
     */
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

    /**
     * Deletes an event from the database.
     * 
     * @param int $id The ID of the event to delete.
     * @return bool Returns true if the event is successfully deleted.
     * @throws \Exception If event deletion fails.
     */
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

    /**
     * Paginates events from the database.
     * 
     * @param int $perPage The number of events to return per page.
     * @param int $page The current page number.
     * @param int|string $status Optional status filter for events.
     * @return array Returns an associative array of paginated events.
     * @throws \Exception If pagination fails.
     */
    public function paginate(int $perPage = 10, int $page = 1, int|string $status = null): array
    {
        try {
            $statusCondition = $status !== null ? "WHERE e.status = :status" : "";
            $offset = ($page - 1) * $perPage;

            $query = "SELECT 
                    e.id, e.name, e.slug, e.description, e.date, e.location, 
                    e.max_capacity, e.status, e.created_by, u.name AS created_by_name, 
                    e.created_at, e.updated_at,
                    (e.max_capacity - COALESCE(a.attendee_count, 0)) AS remaining_tickets
                  FROM {$this->table_name} e
                  LEFT JOIN (
                      SELECT event_id, COUNT(*) AS attendee_count 
                      FROM attendees 
                      GROUP BY event_id
                  ) a ON e.id = a.event_id
                  LEFT JOIN users u ON e.created_by = u.id
                  $statusCondition
                  ORDER BY e.id DESC
                  LIMIT :perPage OFFSET :offset";

            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

            if ($status !== null) {
                $paramType = is_int($status) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindParam(':status', $status, $paramType);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception("Pagination failed: " . $e->getMessage());
        }
    }

    /**
     * Counts the total number of events in the database, optionally filtered by status.
     * 
     * @param int|string $status Optional status filter for events.
     * @return int Returns the total number of events.
     * @throws \Exception If counting events fails.
     */
    public function count(int|string $status = null): int
    {
        try {
            $statusCondition = $status !== null ? " WHERE status = :status" : "";
            $query = "SELECT COUNT(*) as total FROM {$this->table_name} $statusCondition";

            $stmt = $this->connect()->prepare($query);

            if ($status !== null) {
                $paramType = is_int($status) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindParam(':status', $status, $paramType);
            }

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            throw new \Exception("Counting users failed: " . $e->getMessage());
        }
    }
}
