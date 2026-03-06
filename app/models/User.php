<?php
// app/models/User.php
class User {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function findByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1 LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($name, $email, $password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'student')");
        $stmt->bind_param("sss", $name, $email, $hashed);
        return $stmt->execute();
    }

    public function getAll() {
        $result = $this->conn->query("SELECT id, name, email, role, is_active, created_at FROM users ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function toggleActive($id) {
        $stmt = $this->conn->prepare("UPDATE users SET is_active = NOT is_active WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function emailExists($email) {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT id, name, email, role, is_active, created_at FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateProfile($id, $name) {
        $stmt = $this->conn->prepare("UPDATE users SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);
        return $stmt->execute();
    }

    public function changePassword($id, $newPassword) {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed, $id);
        return $stmt->execute();
    }

    public function verifyPassword($id, $currentPassword) {
        $stmt = $this->conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result && password_verify($currentPassword, $result['password'])) {
            return true;
        }
        return false;
    }
}
