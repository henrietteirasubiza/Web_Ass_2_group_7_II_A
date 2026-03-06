<?php
// config/db.php — Database connection (MySQLi)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // Change to your DB user
define('DB_PASS', '');           // Change to your DB password
define('DB_NAME', 'unistack_db');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}
$conn->set_charset('utf8mb4');
