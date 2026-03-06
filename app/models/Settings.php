<?php
class Settings {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll(): array {
        $result = $this->conn->query("SELECT setting_key, setting_value FROM settings ORDER BY setting_key");
        $settings = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        }
        return $settings;
    }

    public function save(array $data): void {
        $stmt = $this->conn->prepare(
            "INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)"
        );
        foreach ($data as $key => $value) {
            $stmt->bind_param("ss", $key, $value);
            $stmt->execute();
        }
    }
}
