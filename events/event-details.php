<?php
include 'includes/header.php';
include 'includes/navbar.php';
require_once 'config/database.php';
require_once 'classes/Event.php';
?>


<div class="container mt-5">
    <h2><?= htmlspecialchars($event['name']) ?></h2>
    <p><?= htmlspecialchars($event['description']) ?></p>
    <p>Max Capacity: <?= $event['max_capacity'] ?></p>
    <a href="index.php" class="btn btn-secondary">Back to List</a>
</div>

<?php include 'includes/footer.php'; ?>