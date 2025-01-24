<?php
include 'includes/header.php';
include 'includes/navbar.php';
require_once 'config/database.php';
require_once 'classes/Event.php';
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
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= htmlspecialchars($event['name']) ?></td>
                    <td><?= htmlspecialchars($event['description']) ?></td>
                    <td><?= $event['max_capacity'] ?></td>
                    <td>
                        <a href="event-details.php?id=<?= $event['id'] ?>" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>