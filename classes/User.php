<?php
require_once '../config/database.php';

class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = getDatabaseConnection();
    }

    public function register($username, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function login($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($userId, $username, $hashedPassword);
        if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
            $stmt->close();
            return ['id' => $userId, 'username' => $username];
        }
        $stmt->close();
        return null;
    }

    public function getById($userId)
    {
        $stmt = $this->conn->prepare("SELECT id, username, email, created_at FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }
}
