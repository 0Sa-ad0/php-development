<?php
// require_once 'User.php';
// require_once 'Event.php';
require_once 'header.php';
require_once 'navbar.php';
// require_once 'database.php';

session_start();
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin/dashboard.php');
        exit();
    } elseif ($_SESSION['role'] === 'user') {
        header('Location: dashboard.php');
        exit();
    }
}
?>



<div class="container mt-5">
    <h1 class="text-center">Welcome to the Event Management System</h1>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Register</h5>
                    <p class="card-text">Create a new account to manage and register for events.</p>
                    <a href="register.php" class="btn btn-primary">Go to Registration</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Login</h5>
                    <p class="card-text">Access your account to view and manage events.</p>
                    <a href="login.php" class="btn btn-success">Go to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'footer.php';
?>