<?php
// app/controllers/ProfileController.php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Post.php';

class ProfileController {
    private $conn;
    private $userModel;
    private $postModel;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->userModel = new User($conn);
        $this->postModel = new Post($conn);
    }

    public function view() {
        $user = $this->userModel->getById($_SESSION['user_id']);
        if (!$user) {
            header('Location: index.php?page=home&error=User not found.');
            exit;
        }
        
        $post_count = 0;
        if ($user['role'] === 'student') {
            $posts = $this->postModel->getByUser($_SESSION['user_id']);
            $post_count = count($posts);
        }
        
        require_once __DIR__ . '/../views/shared/profile.php';
    }

    public function edit() {
        $user = $this->userModel->getById($_SESSION['user_id']);
        if (!$user) {
            header('Location: index.php?page=home&error=User not found.');
            exit;
        }
        require_once __DIR__ . '/../views/shared/profile_edit.php';
    }

    public function update() {
        $name = trim($_POST['name'] ?? '');
        
        if (empty($name)) {
            header('Location: index.php?page=profile&action=edit&error=Name is required.');
            exit;
        }

        $this->userModel->updateProfile($_SESSION['user_id'], $name);
        $_SESSION['name'] = $name;
        
        header('Location: index.php?page=profile&action=view&success=Profile updated successfully.');
        exit;
    }

    public function changePassword() {
        require_once __DIR__ . '/../views/shared/profile_change_password.php';
    }

    public function updatePassword() {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            header('Location: index.php?page=profile&action=changePassword&error=All fields are required.');
            exit;
        }

        if (!$this->userModel->verifyPassword($_SESSION['user_id'], $currentPassword)) {
            header('Location: index.php?page=profile&action=changePassword&error=Current password is incorrect.');
            exit;
        }

        if ($newPassword !== $confirmPassword) {
            header('Location: index.php?page=profile&action=changePassword&error=New passwords do not match.');
            exit;
        }

        if (strlen($newPassword) < 6) {
            header('Location: index.php?page=profile&action=changePassword&error=Password must be at least 6 characters.');
            exit;
        }

        $this->userModel->changePassword($_SESSION['user_id'], $newPassword);
        
        header('Location: index.php?page=profile&action=view&success=Password changed successfully.');
        exit;
    }
}
