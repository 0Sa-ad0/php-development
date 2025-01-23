<?php
require_once '../config/database.php';

$searchQuery = isset($_GET['query']) ? htmlspecialchars(trim($_GET['query'])) : '';
$conn = getDatabaseConnection();

$query = "SELECT id, name, description, max_capacity, created_at 
          FROM events 
          WHERE name LIKE ? OR description LIKE ? 
          ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$searchTerm = "%$searchQuery%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode(['success' => true, 'events' => $events]);

$stmt->close();
$conn->close();
