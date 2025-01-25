<?php
require_once 'database.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$conn = getDatabaseConnection();

$query = "SELECT e.id, e.name, e.description, e.max_capacity, COUNT(a.id) AS attendees_count 
          FROM events e 
          LEFT JOIN attendees a ON e.id = a.event_id 
          GROUP BY e.id 
          ORDER BY e.created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Admin Dashboard</h2>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Description</th>
                    <th>Max Capacity</th>
                    <th>Attendees Count</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($event = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($event['name']) ?></td>
                            <td><?= htmlspecialchars($event['description']) ?></td>
                            <td><?= $event['max_capacity'] ?></td>
                            <td><?= $event['attendees_count'] ?></td>
                            <td>
                                <a href="download-report.php?event_id=<?= $event['id'] ?>"
                                    class="btn btn-success btn-sm">Download Report</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No events available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php $conn->close(); ?>