<?php
// app/controllers/AuthController.php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $conn;
    private $userModel;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->userModel = new User($conn);
    }

    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                $redirect = match($user['role']) {
                    'admin' => 'index.php?page=admin&action=index',
                    'moderator' => 'index.php?page=moderator&action=index',
                    default => 'index.php?page=student'
                };
                header("Location: $redirect");
                exit;
            } else {
                $error = 'Invalid email or password.';
            }
        }
        require_once __DIR__ . '/../views/shared/login.php';
    }

    public function register() {
        $error = '';
        $success = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            // School email pattern validation
            if (!preg_match('/^[a-zA-Z0-9._%+\-]+@ines\.ac\.rw$/', $email)) {
                $error = 'Only @ines.ac.rw school email addresses are allowed.';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters.';
            } elseif ($password !== $confirm) {
                $error = 'Passwords do not match.';
            } elseif ($this->userModel->emailExists($email)) {
                $error = 'This email is already registered.';
            } else {
                if ($this->userModel->create($name, $email, $password)) {
                    $success = 'Registration successful! You can now log in.';
                } else {
                    $error = 'Registration failed. Please try again.';
                }
            }
        }
        require_once __DIR__ . '/../views/shared/register.php';
    }

    public function logout() {
        session_destroy();
        header('Location: index.php?page=auth&action=login');
        exit;
    }
}
