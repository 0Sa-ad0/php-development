<?php
include 'includes/header.php';
include 'includes/navbar.php';
require_once 'config/database.php';
require_once 'classes/Event.php';
require_once 'classes/Validator.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Create New Event</h2>
    <form action="event-create.php" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Event Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="max_capacity" class="form-label">Max Capacity</label>
            <input type="number" class="form-control" id="max_capacity" name="max_capacity" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Event</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>