<?php
define('BASE_URL', '');
$pageTitle = 'Edit Profile — UniStack';
require_once __DIR__ . '/header.php';
?>

<h2 class="section-title"><i class="fas fa-user-edit"></i> Edit Profile</h2>

<div class="form-card" style="max-width:500px;">
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=profile&action=update">
        <div class="form-group">
            <label><i class="fas fa-user"></i> Full Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="form-group" style="margin-bottom:0;">
            <label><i class="fas fa-envelope"></i> Email (Cannot change)</label>
            <input type="text" value="<?= htmlspecialchars($user['email']) ?>" disabled style="background:#f3f4f6;cursor:not-allowed;">
            <p class="form-hint">Email is locked for security reasons.</p>
        </div>

        <div style="display:flex;gap:.75rem;margin-top:2rem;flex-wrap:wrap;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            <a href="index.php?page=profile&action=view" class="btn btn-outline"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
