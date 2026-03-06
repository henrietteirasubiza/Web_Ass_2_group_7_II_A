<?php
define('BASE_URL', '');
$pageTitle = 'Change Password — UniStack';
require_once __DIR__ . '/header.php';
?>

<main class="main-content">
    <div class="form-card">
        <h1><i class="fa-solid fa-lock"></i> Change Password</h1>
            
            <?php if (!empty($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?page=profile&action=updatePassword">
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required 
                           placeholder="Enter your current password">
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required 
                           placeholder="Enter new password (min 6 characters)">
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required 
                           placeholder="Confirm new password">
                </div>

                <div class="form-actions">
                    <a href="index.php?page=profile&action=view" class="btn btn-outline">
                        <i class="fa-solid fa-arrow-left"></i> Back to Profile
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-check"></i> Change Password
                    </button>
                </div>
            </form>
    </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>
