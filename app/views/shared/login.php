<?php
define('BASE_URL', '');
$pageTitle = 'Login — UniStack';
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
    <div class="auth-card">
        <div class="logo">
            <h1>🎓 UniStack</h1>
            <p>INES Digital Notice Board &amp; Marketplace</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=auth&action=login">
            <div class="form-group">
                <label for="email">School Email</label>
                <input type="email" id="email" name="email" placeholder="yourname@ines.ac.rw" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:.75rem;">Login</button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="index.php?page=auth&action=register">Register here</a>
        </div>
        <div class="auth-footer" style="margin-top:.5rem; font-size:.78rem; color:#9ca3af;">
            <a href="index.php?page=home" class="auth-back"><span class="arrow"><i class="fas fa-arrow-left"></i></span> Home</a>
    </div>
</div>
</body>
</html>
