<?php
include 'header.php';
include 'navbar.php';
include 'footer.php';
require_once 'database.php';
require_once 'Event.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Register for Event</h2>
    <form action="register-event.php" method="POST" id="registrationForm">
        <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
        <p>Event: <?= htmlspecialchars($event['name']) ?></p>
        <button type="submit" class="btn btn-success">Register</button>
    </form>
    <a href="index.php" class="btn btn-secondary mt-3">Back to List</a>
</div>