<?php
// app/controllers/ModeratorController.php
require_once __DIR__ . '/../models/Post.php';

class ModeratorController {
    private $conn;
    private $postModel;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->postModel = new Post($conn);
    }

    private function logAction($action, $target_id = null) {
        $stmt = $this->conn->prepare("INSERT INTO audit_log (user_id, action, target_id) VALUES (?,?,?)");
        $stmt->bind_param("isi", $_SESSION['user_id'], $action, $target_id);
        $stmt->execute();
    }

    public function dashboard() {
        $pending = $this->postModel->getPending();
        $stats = $this->postModel->getStats();
        require_once __DIR__ . '/../views/moderator/dashboard.php';
    }

    public function approve() {
        $id = intval($_GET['id'] ?? 0);
        $this->postModel->updateStatus($id, 'approved', $_SESSION['user_id']);
        $this->logAction("Approved post ID $id", $id);
        header('Location: index.php?page=moderator&action=index&success=Post approved.');
        exit;
    }

    public function reject() {
        $id = intval($_GET['id'] ?? 0);
        $this->postModel->updateStatus($id, 'rejected', $_SESSION['user_id']);
        $this->logAction("Rejected post ID $id", $id);
        header('Location: index.php?page=moderator&action=index&success=Post rejected.');
        exit;
    }

    public function flags() {
        $flagged = $this->postModel->getFlagged();
        require_once __DIR__ . '/../views/moderator/flags.php';
    }

    public function viewReports() {
        $post_id = intval($_GET['id'] ?? 0);
        $post = $this->postModel->getById($post_id);
        if (!$post) {
            header('Location: index.php?page=moderator&action=flags&error=Post not found.');
            exit;
        }
        $reports = $this->postModel->getReportsByPost($post_id);
        require_once __DIR__ . '/../views/moderator/view_reports.php';
    }
}
