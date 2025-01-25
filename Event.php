<?php
require_once 'database.php';

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

    public function registerAttendee($eventId, $userId)
    {
        // Check if the user is already registered
        $stmt = $this->conn->prepare("SELECT * FROM event_attendees WHERE event_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $eventId, $userId);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->close();
            return false; // Already registered
        }
        $stmt->close();

        $maxCapacity = 0;
        $currentAttendees = 0;

        // Check if the event has capacity
        $stmt = $this->conn->prepare("
            SELECT max_capacity, 
                   (SELECT COUNT(*) FROM event_attendees WHERE event_id = ?) AS current_attendees 
            FROM events 
            WHERE id = ?
        ");
        $stmt->bind_param("ii", $eventId, $eventId);
        $stmt->execute();
        $stmt->bind_result($maxCapacity, $currentAttendees);
        if (!$stmt->fetch()) {
            $stmt->close();
            return false; // Event not found
        }
        $stmt->close();

        if ($currentAttendees >= $maxCapacity) {
            return false; // Event is full
        }

        // Register the user
        $stmt = $this->conn->prepare("INSERT INTO event_attendees (event_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $eventId, $userId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

}
