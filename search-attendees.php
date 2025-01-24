<?php
require_once 'database.php';
require_once 'Event.php';

$eventId = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
$searchQuery = isset($_GET['query']) ? htmlspecialchars(trim($_GET['query'])) : '';

if ($eventId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid event ID.']);
    exit();
}

$conn = getDatabaseConnection();

$query = "SELECT u.username, u.email, a.registered_at 
          FROM attendees a 
          JOIN users u ON a.user_id = u.id 
          WHERE a.event_id = ? AND (u.username LIKE ? OR u.email LIKE ?)";
$stmt = $conn->prepare($query);
$searchTerm = "%$searchQuery%";
$stmt->bind_param("iss", $eventId, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$attendees = [];
while ($row = $result->fetch_assoc()) {
    $attendees[] = $row;
}

echo json_encode(['success' => true, 'attendees' => $attendees]);

$stmt->close();
$conn->close();
