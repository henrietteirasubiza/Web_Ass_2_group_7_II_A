<?php
define('BASE_URL', '');
$pageTitle = 'New Post — UniStack';
require_once __DIR__ . '/../shared/header.php';
?>
<div class="form-card">
    <h2>📝 Create New Post</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="index.php?page=posts&action=store">
        <div class="form-group">
            <label>Post Type *</label>
            <select name="type" id="post-type" onchange="togglePrice()" required>
                <option value="">Select a type...</option>
                <option value="for_sale">🛒 For Sale</option>
                <option value="housing">🏠 Housing</option>
                <option value="announcement">📢 Announcement</option>
            </select>
        </div>
        <div class="form-group">
            <label>Title *</label>
            <input type="text" name="title" placeholder="Descriptive title for your post" required maxlength="200">
        </div>
        <div class="form-group">
            <label>Description *</label>
            <textarea name="description" placeholder="Describe what you're offering, condition, availability, etc." required></textarea>
        </div>
        <div class="form-group" id="price-group" style="display:none;">
            <label>Price (RWF)</label>
            <input type="number" name="price" id="price-input" min="0" step="100" placeholder="0" oninput="updatePricePreview()">
            <p class="form-hint" id="price-preview"></p>
        </div>
        <div class="form-group">
            <label>Contact Info</label>
            <input type="text" name="contact" placeholder="Phone number or email">
        </div>
        <div style="display:flex;gap:.75rem;justify-content:flex-end;margin-top:1.5rem;">
            <a href="index.php?page=student" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit for Review</button>
        </div>
    </form>
</div>
<script>
function togglePrice() {
    const t = document.getElementById('post-type').value;
    const pg = document.getElementById('price-group');
    pg.style.display = (t === 'for_sale' || t === 'housing') ? 'block' : 'none';
}
function updatePricePreview() {
    const v = parseFloat(document.getElementById('price-input').value) || 0;
    document.getElementById('price-preview').textContent = v > 0 ? '💵 ' + v.toLocaleString('en') + ' RWF' : '';
}
</script>
<?php require_once __DIR__ . '/../shared/footer.php'; ?>
