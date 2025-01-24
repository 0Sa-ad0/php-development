<?php
require_once 'database.php';
require_once 'Event.php';

header('Content-Type: application/json');

$conn = getDatabaseConnection();
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'GET') {
    $query = "SELECT id, name, description, max_capacity, created_at FROM events ORDER BY created_at DESC";
    $result = $conn->query($query);
    $events = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode(['success' => true, 'events' => $events]);
} elseif ($requestMethod === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $name = htmlspecialchars(trim($input['name']));
    $description = htmlspecialchars(trim($input['description']));
    $maxCapacity = intval($input['max_capacity']);

    if (!$name || !$description || $maxCapacity <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO events (name, description, max_capacity) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $name, $description, $maxCapacity);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Event created successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create event.']);
    }
    $stmt->close();
} elseif ($requestMethod === 'DELETE') {
    parse_str(file_get_contents('php://input'), $input);
    $eventId = intval($input['id']);

    if ($eventId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid event ID.']);
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $eventId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Event deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete event.']);
    }
    $stmt->close();
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
}

$conn->close();
