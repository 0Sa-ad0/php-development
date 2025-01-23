<?php
require_once '../config/database.php';

if (!isset($_GET['event_id']) || !is_numeric($_GET['event_id'])) {
    header("Location: dashboard.php");
    exit();
}

$eventId = intval($_GET['event_id']);
$conn = getDatabaseConnection();

$query = "SELECT u.username, u.email, a.registered_at 
          FROM attendees a 
          JOIN users u ON a.user_id = u.id 
          WHERE a.event_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $eventId);
$stmt->execute();
$result = $stmt->get_result();

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=event_report_{$eventId}.csv");

$output = fopen('php://output', 'w');
fputcsv($output, ['Username', 'Email', 'Registered At']);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [$row['username'], $row['email'], $row['registered_at']]);
}

fclose($output);
$stmt->close();
$conn->close();
exit();
