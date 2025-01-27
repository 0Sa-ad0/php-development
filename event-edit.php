<?php
include 'header.php';
include 'navbar.php';
require_once 'database.php';
require_once 'Event.php';
require_once 'Validator.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Edit Event</h2>
    <form action="event-edit.php?id=<?= $event['id'] ?>" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Event Name</label>
            <input type="text" class="form-control" id="name" name="name"
                value="<?= htmlspecialchars($event['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"
                required><?= htmlspecialchars($event['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="max_capacity" class="form-label">Max Capacity</label>
            <input type="number" class="form-control" id="max_capacity" name="max_capacity"
                value="<?= $event['max_capacity'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Event</button>
    </form>
</div>
<?php include 'footer.php'; ?>