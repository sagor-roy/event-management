<?php

namespace App\Model;

use Config\Database;
use PDO;
use PDOException;

class Attendee extends Database
{
    private string $table_name = "attendees";

    /**
     * Retrieves all attendees for a given event.
     *
     * @param int|string $event_id The event ID to fetch attendees for.
     * @return array|false The list of attendees or false on failure.
     * @throws \Exception If data fetching fails.
     */
    public function getAll(int|string $event_id): array|false
    {
        try {
            $query = "SELECT id, event_id, name, email, phone, registered_at FROM $this->table_name WHERE event_id = :event_id";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception("Data fetching failed: " . $e->getMessage());
        }
    }


    /**
     * Check if a phone number is already registered for a specific event.
     *
     * @param int|string $event_id The event ID to check against.
     * @param string $phone The phone number to check for existence.
     * @return bool Returns true if the phone number is already registered, false otherwise.
     * @throws \Exception If there is an error executing the query.
     */
    public function isPhoneRegistered(int|string $event_id, string $phone): bool
    {
        try {
            $query = "SELECT COUNT(*) FROM $this->table_name WHERE event_id = :event_id AND phone = :phone";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            throw new \Exception("Error checking phone registration: " . $e->getMessage());
        }
    }


    /**
     * Retrieves the first attendee matching a given column condition.
     *
     * @param string $column The column name to filter by.
     * @param string $operator The comparison operator (e.g., '=', '!=' '<', 'LIKE').
     * @param mixed $value The value to compare against.
     * @return array|false The first matching attendee or false if none found.
     * @throws \InvalidArgumentException If an invalid operator is used.
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
     * Creates a new registration record in the database.
     * 
     * @param array $data User data containing name, email, phone, event_id and password
     * @return bool True on successful creation
     * @throws \Exception If creation fails
     */
    public function create(array $data): bool
    {
        try {
            $query = "INSERT INTO $this->table_name (event_id, name, email, phone) VALUES (:event_id, :name, :email, :phone)";
            $stmt = $this->connect()->prepare($query);

            $stmt->bindParam(':event_id', $data['event_id']);
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new \Exception("registration creation failed: " . $e->getMessage());
        }
    }

    /**
     * Retrieves a paginated list of attendees for a given event.
     *
     * @param int $perPage The number of attendees per page.
     * @param int $page The current page number.
     * @param int|string $event_id The event ID to filter attendees.
     * @return array The paginated list of attendees.
     * @throws \Exception If pagination query fails.
     */
    public function paginate(int|string $event_id, int $perPage = 10, int $page = 1): array
    {
        try {
            $offset = ($page - 1) * $perPage;
            $query = "SELECT *
                      FROM $this->table_name
                      WHERE event_id = :event_id
                      ORDER BY id DESC
                      LIMIT :perPage OFFSET :offset";

            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
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
    public function count(int|string $event_id = null): int
    {
        try {
            $statusCondition = $event_id !== null ? " WHERE event_id = :event_id" : "";
            $query = "SELECT COUNT(*) as total FROM {$this->table_name} $statusCondition";

            $stmt = $this->connect()->prepare($query);

            if ($event_id !== null) {
                $paramType = is_int($event_id) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindParam(':event_id', $event_id, $paramType);
            }

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            throw new \Exception("Counting users failed: " . $e->getMessage());
        }
    }
}
