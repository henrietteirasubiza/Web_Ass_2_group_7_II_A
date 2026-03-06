<?php
// app/controllers/AdminController.php
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Settings.php';

class AdminController {
    private $conn;
    private $postModel;
    private $userModel;
    private $settingsModel;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->postModel = new Post($conn);
        $this->userModel = new User($conn);
        $this->settingsModel = new Settings($conn);
    }

    private function logAction($action, $target_id = null) {
        $stmt = $this->conn->prepare("INSERT INTO audit_log (user_id, action, target_id) VALUES (?,?,?)");
        $stmt->bind_param("isi", $_SESSION['user_id'], $action, $target_id);
        $stmt->execute();
    }

    public function dashboard() {
        $stats = $this->postModel->getStats();
        $posts = $this->postModel->getAll();
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    public function users() {
        $users = $this->userModel->getAll();
        require_once __DIR__ . '/../views/admin/users.php';
    }

    public function toggleUser() {
        $id = intval($_GET['id'] ?? 0);
        $this->userModel->toggleActive($id);
        $this->logAction("Toggled user ID $id active status", $id);
        header('Location: index.php?page=admin&action=users&success=User status updated.');
        exit;
    }

    public function deletePost() {
        $id = intval($_GET['id'] ?? 0);
        $this->postModel->adminDelete($id);
        $this->logAction("Admin deleted post ID $id", $id);
        header('Location: index.php?page=admin&action=index&success=Post deleted.');
        exit;
    }

    public function audit() {
        $result = $this->conn->query("SELECT a.*, u.name, u.email FROM audit_log a JOIN users u ON a.user_id = u.id ORDER BY a.created_at DESC LIMIT 100");
        $logs = $result->fetch_all(MYSQLI_ASSOC);
        require_once __DIR__ . '/../views/admin/audit.php';
    }

    public function viewReports() {
        $post_id = intval($_GET['id'] ?? 0);
        $post = $this->postModel->getById($post_id);
        if (!$post) {
            header('Location: index.php?page=admin&action=index&error=Post not found.');
            exit;
        }
        $reports = $this->postModel->getReportsByPost($post_id);
        require_once __DIR__ . '/../views/admin/view_reports.php';
    }

    public function settings() {
        $settings = $this->settingsModel->getAll();
        require_once __DIR__ . '/../views/admin/settings.php';
    }

    public function saveSettings() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin&action=settings');
            exit;
        }
        $allowed = ['site_name', 'site_tagline', 'contact_email', 'posts_per_page', 'allow_registration', 'maintenance_mode'];
        $data = [];
        foreach ($allowed as $key) {
            $data[$key] = trim($_POST[$key] ?? '');
        }
        $data['allow_registration'] = isset($_POST['allow_registration']) ? '1' : '0';
        $data['maintenance_mode']   = isset($_POST['maintenance_mode'])   ? '1' : '0';
        $this->settingsModel->save($data);
        $this->logAction('Updated site settings');
        header('Location: index.php?page=admin&action=settings&success=Settings saved successfully.');
        exit;
    }
}
