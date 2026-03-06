-- UniStack Database Schema
-- INES Digital Notice Board + Marketplace

CREATE DATABASE IF NOT EXISTS unistack_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE unistack_db;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student','moderator','admin') DEFAULT 'student',
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Posts table
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    type ENUM('for_sale','housing','announcement') NOT NULL,
    price DECIMAL(10,2) DEFAULT NULL,
    contact VARCHAR(100) DEFAULT NULL,
    status ENUM('pending','approved','rejected') DEFAULT 'pending',
    is_flagged TINYINT(1) DEFAULT 0,
    flag_reason TEXT DEFAULT NULL,
    moderated_by INT DEFAULT NULL,
    moderated_at DATETIME DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (moderated_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Flags/Reports table
CREATE TABLE reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    reported_by INT NOT NULL,
    reason VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (reported_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Audit log
CREATE TABLE audit_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(255) NOT NULL,
    target_id INT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Site settings table
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT DEFAULT NULL,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'UniStack'),
('site_tagline', 'INES Notice Board'),
('allow_registration', '1'),
('maintenance_mode', '0'),
('contact_email', 'admin@ines.ac.rw'),
('posts_per_page', '12')
ON DUPLICATE KEY UPDATE setting_key = setting_key;

-- Default users (passwords: Admin@123, Mod@123, Student@123)
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@ines.ac.rw', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Moderator One', 'mod@ines.ac.rw', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'moderator'),
('Student Demo', 'student@ines.ac.rw', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student');

-- Note: all passwords above hash to "password" — update after import
-- To generate real hashes use: php -r "echo password_hash('YourPassword', PASSWORD_DEFAULT);"

-- Sample approved posts
INSERT INTO posts (user_id, title, description, type, price, contact, status, moderated_by, moderated_at) VALUES
(3, 'Calculus Textbook for Sale', 'Good condition Calculus 2 textbook, barely used. Author: Thomas.', 'for_sale', 3000.00, '0789000001', 'approved', 2, NOW()),
(3, 'Room Available near INES', 'Single room, 15 min walk to campus. Quiet neighborhood. Meals optional.', 'housing', 25000.00, '0789000002', 'approved', 2, NOW()),
(3, 'Hackathon This Saturday!', 'Join the INES coding hackathon. Teams of 3-5. Prize: 50,000 RWF.', 'announcement', NULL, 'ines.ac.rw', 'approved', 2, NOW());
