<?php
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/footer.php';
require_once 'config/database.php';
require_once 'classes/Event.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Register for Event</h2>
    <form action="ajax/register-event.php" method="POST" id="registrationForm">
        <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
        <p>Event: <?= htmlspecialchars($event['name']) ?></p>
        <button type="submit" class="btn btn-success">Register</button>
    </form>
    <a href="index.php" class="btn btn-secondary mt-3">Back to List</a>
</div>