<?php
include 'header.php';
include 'navbar.php';
require_once 'database.php';
require_once 'Event.php';
?>


<div class="container mt-5">
    <h2><?= htmlspecialchars($event['name']) ?></h2>
    <p><?= htmlspecialchars($event['description']) ?></p>
    <p>Max Capacity: <?= $event['max_capacity'] ?></p>
    <a href="index.php" class="btn btn-secondary">Back to List</a>
</div>

<?php include 'footer.php'; ?>