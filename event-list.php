<?php
include 'header.php';
include 'navbar.php';
require_once 'database.php';
require_once 'Event.php';

$conn = getDatabaseConnection();
$eventObj = new Event($conn);
$events = $eventObj->getAllEvents();


?>

<div class="container mt-5">
    <h2 class="mb-4">Event List</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Max Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($events && $events->num_rows > 0): ?>
                <?php while ($event = $events->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['name']) ?></td>
                        <td><?= htmlspecialchars($event['description']) ?></td>
                        <td><?= htmlspecialchars($event['max_capacity']) ?></td>
                        <td>
                            <a href="event-details.php?id=<?= $event['id'] ?>" class="btn btn-info btn-sm">View</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No events available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>