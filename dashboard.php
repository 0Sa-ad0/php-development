<?php
require_once 'config/database.php';
require_once 'classes/Event.php';
include 'includes/header.php';
include 'includes/navbar.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = getDatabaseConnection();
$eventObj = new Event($conn);
$result = $eventObj->getAllEvents();

$query = "SELECT * FROM events ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Event Dashboard</h2>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <a href="event-create.php" class="btn btn-primary mb-3">Create New Event</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Max Capacity</th>
                    <th>Created At</th>
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
                            <td><?= $event['created_at'] ?></td>
                            <td>
                                <a href="event-details.php?id=<?= $event['id'] ?>" class="btn btn-info btn-sm">View</a>
                                <a href="event-edit.php?id=<?= $event['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="event-delete.php?id=<?= $event['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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
<?php include 'includes/footer.php'; ?>