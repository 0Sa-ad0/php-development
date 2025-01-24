<?php
require_once '../config/database.php';
require_once '../classes/Event.php';
require_once '../classes/Validator.php';

session_start();

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403);
    exit();
}

$eventId = intval($_POST['event_id']);
$userId = $_SESSION['user_id'];

$conn = getDatabaseConnection();

$query = "SELECT COUNT(*) AS count, max_capacity FROM events 
          LEFT JOIN attendees ON events.id = attendees.event_id 
          WHERE events.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $eventId);
$stmt->execute();
$stmt->bind_result($attendeeCount, $maxCapacity);
$stmt->fetch();
$stmt->close();

if ($attendeeCount >= $maxCapacity) {
    echo json_encode(['success' => false, 'message' => 'Event is already at full capacity.']);
    exit();
}

$stmt = $conn->prepare("INSERT INTO attendees (event_id, user_id) VALUES (?, ?)");
$stmt->bind_param("ii", $eventId, $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Successfully registered for the event.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to register for the event.']);
}

$stmt->close();
$conn->close();
