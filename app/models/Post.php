<?php
// app/models/Post.php
class Post {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getApproved($search = '', $type = '') {
        $sql = "SELECT p.*, u.name AS author FROM posts p 
                JOIN users u ON p.user_id = u.id 
                WHERE p.status = 'approved'";
        $params = [];
        $types = '';

        if ($search) {
            $sql .= " AND (p.title LIKE ? OR p.description LIKE ?)";
            $like = "%$search%";
            $params[] = $like;
            $params[] = $like;
            $types .= 'ss';
        }
        if ($type) {
            $sql .= " AND p.type = ?";
            $params[] = $type;
            $types .= 's';
        }
        $sql .= " ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        if ($params) $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getByUser($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT p.*, u.name AS author FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($user_id, $title, $description, $type, $price, $contact) {
        $stmt = $this->conn->prepare("INSERT INTO posts (user_id, title, description, type, price, contact, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("isssds", $user_id, $title, $description, $type, $price, $contact);
        return $stmt->execute();
    }

    public function update($id, $user_id, $title, $description, $type, $price, $contact) {
        $stmt = $this->conn->prepare("UPDATE posts SET title=?, description=?, type=?, price=?, contact=?, status='pending', updated_at=NOW() WHERE id=? AND user_id=?");
        $stmt->bind_param("sssdsii", $title, $description, $type, $price, $contact, $id, $user_id);
        return $stmt->execute();
    }

    public function delete($id, $user_id) {
        $stmt = $this->conn->prepare("DELETE FROM posts WHERE id=? AND user_id=?");
        $stmt->bind_param("ii", $id, $user_id);
        return $stmt->execute();
    }

    public function adminDelete($id) {
        $stmt = $this->conn->prepare("DELETE FROM posts WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getPending() {
        $stmt = $this->conn->prepare("SELECT p.*, u.name AS author FROM posts p JOIN users u ON p.user_id = u.id WHERE p.status = 'pending' ORDER BY p.created_at ASC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getFlagged() {
        $stmt = $this->conn->prepare("SELECT p.*, u.name AS author, COUNT(r.id) AS report_count FROM posts p JOIN users u ON p.user_id = u.id LEFT JOIN reports r ON r.post_id = p.id WHERE p.is_flagged = 1 GROUP BY p.id ORDER BY report_count DESC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getReportsByPost($post_id) {
        $stmt = $this->conn->prepare("SELECT r.*, u.name AS reporter_name, u.email AS reporter_email FROM reports r JOIN users u ON r.reported_by = u.id WHERE r.post_id = ? ORDER BY r.created_at DESC");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateStatus($id, $status, $mod_id) {
        $stmt = $this->conn->prepare("UPDATE posts SET status=?, moderated_by=?, moderated_at=NOW() WHERE id=?");
        $stmt->bind_param("sii", $status, $mod_id, $id);
        return $stmt->execute();
    }

    public function addReport($post_id, $user_id, $reason) {
        // Flag the post
        $stmt = $this->conn->prepare("UPDATE posts SET is_flagged=1 WHERE id=?");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        // Insert report
        $stmt2 = $this->conn->prepare("INSERT INTO reports (post_id, reported_by, reason) VALUES (?,?,?)");
        $stmt2->bind_param("iis", $post_id, $user_id, $reason);
        return $stmt2->execute();
    }

    public function getStats() {
        $stats = [];
        $r = $this->conn->query("SELECT COUNT(*) AS total FROM posts WHERE status='approved'");
        $stats['approved'] = $r->fetch_assoc()['total'];
        $r = $this->conn->query("SELECT COUNT(*) AS total FROM posts WHERE status='pending'");
        $stats['pending'] = $r->fetch_assoc()['total'];
        $r = $this->conn->query("SELECT COUNT(*) AS total FROM posts WHERE status='rejected'");
        $stats['rejected'] = $r->fetch_assoc()['total'];
        $r = $this->conn->query("SELECT COUNT(*) AS total FROM posts WHERE is_flagged=1");
        $stats['flagged'] = $r->fetch_assoc()['total'];
        $r = $this->conn->query("SELECT COUNT(*) AS total FROM users WHERE role='student'");
        $stats['students'] = $r->fetch_assoc()['total'];
        return $stats;
    }

    public function getAll() {
        $result = $this->conn->query("SELECT p.*, u.name AS author FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
