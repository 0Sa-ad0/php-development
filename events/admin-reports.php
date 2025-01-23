<div class="container mt-5">
    <h2 class="mb-4">Admin Reports</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Max Capacity</th>
                <th>Attendees</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= htmlspecialchars($event['name']) ?></td>
                    <td><?= $event['max_capacity'] ?></td>
                    <td><?= $event['attendees_count'] ?></td>
                    <td>
                        <a href="download-report.php?event_id=<?= $event['id'] ?>" class="btn btn-success btn-sm">Download
                            CSV</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>