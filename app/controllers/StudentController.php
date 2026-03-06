<?php
// app/controllers/StudentController.php
require_once __DIR__ . '/../models/Post.php';

class StudentController {
    private $conn;
    public function __construct($conn) { $this->conn = $conn; }

    public function dashboard() {
        $postModel = new Post($this->conn);
        $posts = $postModel->getByUser($_SESSION['user_id']);
        $my = ['total'=>0,'approved'=>0,'pending'=>0,'rejected'=>0];
        foreach ($posts as $p) {
            $my['total']++;
            $my[$p['status']]++;
        }
        require_once __DIR__ . '/../views/student/dashboard.php';
    }
}
