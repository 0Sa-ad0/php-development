<?php
require_once __DIR__ . 'database.php';

class Event
{
    private $conn;

    // public function __construct()
    // {
    //     $this->conn = getDatabaseConnection();
    // }

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    public function create($name, $description, $maxCapacity, $userId)
    {
        $stmt = $this->conn->prepare("INSERT INTO events (name, description, max_capacity, created_by) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $name, $description, $maxCapacity, $userId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function getAllEvents()
    {
        $query = "SELECT * FROM events ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getById($eventId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result->fetch_assoc();
        $stmt->close();
        return $event;
    }

    public function delete($eventId)
    {
        $stmt = $this->conn->prepare("DELETE FROM events WHERE id = ?");
        $stmt->bind_param("i", $eventId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}
