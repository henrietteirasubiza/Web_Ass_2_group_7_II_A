<?php
define('BASE_URL', '');
$pageTitle = 'Register — UniStack';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="auth-wrapper">
    <a href="index.php?page=home" class="auth-back"><span class="arrow"><i class="fas fa-arrow-left"></i></span> Home</a>
    <div class="auth-card">
        <div class="logo">
            <h1><i class="fas fa-graduation-cap"></i> UniStack</h1>
            <p>Create Your Student Account</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=auth&action=register">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Your full name" required>
            </div>
            <div class="form-group">
                <label>School Email</label>
                <input type="email" name="email" placeholder="yourname@ines.ac.rw" required>
                <p class="form-hint">⚠️ Only @ines.ac.rw email addresses are accepted.</p>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="At least 6 characters" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm" placeholder="Repeat password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:.75rem;">Create Account</button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="index.php?page=auth&action=login">Login</a>
        </div>
    </div>
</div>
</body>
</html>
