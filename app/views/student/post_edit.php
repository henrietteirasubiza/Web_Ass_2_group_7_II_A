<?php
define('BASE_URL', '');
$pageTitle = 'Edit Post — UniStack';
require_once __DIR__ . '/../shared/header.php';
?>
<div class="form-card">
    <h2>✏️ Edit Post</h2>
    <form method="POST" action="index.php?page=posts&action=update">
        <input type="hidden" name="id" value="<?= $post['id'] ?>">
        <div class="form-group">
            <label>Post Type *</label>
            <select name="type" required>
                <option value="for_sale" <?= $post['type']==='for_sale'?'selected':'' ?>>🛒 For Sale</option>
                <option value="housing" <?= $post['type']==='housing'?'selected':'' ?>>🏠 Housing</option>
                <option value="announcement" <?= $post['type']==='announcement'?'selected':'' ?>>📢 Announcement</option>
            </select>
        </div>
        <div class="form-group">
            <label>Title *</label>
            <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required maxlength="200">
        </div>
        <div class="form-group">
            <label>Description *</label>
            <textarea name="description" required><?= htmlspecialchars($post['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Price (RWF)</label>
            <input type="number" name="price" value="<?= $post['price'] ?>" min="0" step="100">
        </div>
        <div class="form-group">
            <label>Contact Info</label>
            <input type="text" name="contact" value="<?= htmlspecialchars($post['contact']) ?>">
        </div>
        <p class="form-hint" style="margin-bottom:1rem;">⚠️ Editing will resubmit the post for moderator review.</p>
        <div style="display:flex;gap:.75rem;justify-content:flex-end;">
            <a href="index.php?page=student" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/../shared/footer.php'; ?>
