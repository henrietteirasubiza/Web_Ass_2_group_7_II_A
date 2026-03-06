<?php
// app/controllers/PostController.php
require_once __DIR__ . '/../models/Post.php';

class PostController {
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

    public function index() {
        $search = trim($_GET['search'] ?? '');
        $type = $_GET['type'] ?? '';
        $posts = $this->postModel->getApproved($search, $type);
        require_once __DIR__ . '/../views/shared/home.php';
    }

    public function view() {
        $id = intval($_GET['id'] ?? 0);
        $post = $this->postModel->getById($id);
        if (!$post || $post['status'] !== 'approved') {
            header('Location: index.php?page=home');
            exit;
        }
        require_once __DIR__ . '/../views/shared/post_view.php';
    }

    public function create() {
        require_once __DIR__ . '/../views/student/post_form.php';
    }

    public function store() {
        $title = trim($_POST['title'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        $type = $_POST['type'] ?? '';
        $price = floatval($_POST['price'] ?? 0);
        $contact = trim($_POST['contact'] ?? '');

        if (!$title || !$desc || !in_array($type, ['for_sale','housing','announcement'])) {
            $error = 'Please fill all required fields.';
            require_once __DIR__ . '/../views/student/post_form.php';
            return;
        }

        $this->postModel->create($_SESSION['user_id'], $title, $desc, $type, $price, $contact);
        $this->logAction("Created post: $title");
        header('Location: index.php?page=student&success=Post submitted for review.');
        exit;
    }

    public function edit() {
        $id = intval($_GET['id'] ?? 0);
        $post = $this->postModel->getById($id);
        if (!$post || $post['user_id'] != $_SESSION['user_id']) {
            header('Location: index.php?page=student');
            exit;
        }
        require_once __DIR__ . '/../views/student/post_edit.php';
    }

    public function update() {
        $id = intval($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        $type = $_POST['type'] ?? '';
        $price = floatval($_POST['price'] ?? 0);
        $contact = trim($_POST['contact'] ?? '');

        $this->postModel->update($id, $_SESSION['user_id'], $title, $desc, $type, $price, $contact);
        $this->logAction("Updated post ID $id");
        header('Location: index.php?page=student&success=Post updated and resubmitted for review.');
        exit;
    }

    public function delete() {
        $id = intval($_GET['id'] ?? 0);
        $this->postModel->delete($id, $_SESSION['user_id']);
        $this->logAction("Deleted post ID $id");
        header('Location: index.php?page=student&success=Post deleted.');
        exit;
    }

    public function report() {
        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            header('Location: index.php?page=home&error=Invalid post.');
            exit;
        }
        $reason = trim($_POST['reason'] ?? 'Inappropriate content');
        $this->postModel->addReport($id, $_SESSION['user_id'], $reason);
        $this->logAction("Reported post ID $id");
        header('Location: index.php?page=home&success=Post reported.');
        exit;
    }
}
