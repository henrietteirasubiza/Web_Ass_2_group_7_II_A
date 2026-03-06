<?php
// app/controllers/HomeController.php
require_once __DIR__ . '/../models/Post.php';

class HomeController {
    private $conn;
    public function __construct($conn) { $this->conn = $conn; }

    public function index() {
        $postModel = new Post($this->conn);
        $search = trim($_GET['search'] ?? '');
        $type = $_GET['type'] ?? '';

        // by default show only approved posts, but allow administrators (or
        // anyone passing all=1 while logged in) to retrieve the full set for
        // debugging/review. This matches the "fetching all posts from database"
        // requirement.
        $showAll = isset($_GET['all']) && $_GET['all'] == '1' && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

        if ($showAll) {
            $posts = $postModel->getAll();
        } else {
            $posts = $postModel->getApproved($search, $type);
        }

        require_once __DIR__ . '/../views/shared/home.php';
    }
}
