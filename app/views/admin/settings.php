<?php
define('BASE_URL', '');
$pageTitle = 'Site Settings — UniStack';
require_once __DIR__ . '/../shared/header.php';
?>
<h2 class="section-title"><i class="fas fa-sliders-h"></i> Site Settings</h2>

<div class="form-card" style="max-width:700px;">
    <form method="POST" action="index.php?page=admin&action=save_settings">

        <h3 style="margin-bottom:1.25rem;font-size:1.1rem;color:var(--gray-700);border-bottom:2px solid var(--gray-200);padding-bottom:.5rem;">
            <i class="fas fa-globe"></i> General
        </h3>

        <div class="form-group">
            <label for="site_name">Site Name</label>
            <input type="text" id="site_name" name="site_name"
                   value="<?= htmlspecialchars($settings['site_name'] ?? 'UniStack') ?>" required>
        </div>

        <div class="form-group">
            <label for="site_tagline">Tagline</label>
            <input type="text" id="site_tagline" name="site_tagline"
                   value="<?= htmlspecialchars($settings['site_tagline'] ?? 'INES Notice Board') ?>">
        </div>

        <div class="form-group">
            <label for="contact_email">Contact Email</label>
            <input type="email" id="contact_email" name="contact_email"
                   value="<?= htmlspecialchars($settings['contact_email'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="posts_per_page">Posts Per Page</label>
            <input type="number" id="posts_per_page" name="posts_per_page" min="1" max="100"
                   value="<?= intval($settings['posts_per_page'] ?? 12) ?>">
        </div>

        <h3 style="margin:1.5rem 0 1.25rem;font-size:1.1rem;color:var(--gray-700);border-bottom:2px solid var(--gray-200);padding-bottom:.5rem;">
            <i class="fas fa-toggle-on"></i> Access Control
        </h3>

        <div class="form-group" style="display:flex;align-items:center;gap:.75rem;">
            <input type="checkbox" id="allow_registration" name="allow_registration"
                   <?= ($settings['allow_registration'] ?? '1') === '1' ? 'checked' : '' ?>
                   style="width:auto;accent-color:var(--primary);">
            <label for="allow_registration" style="margin:0;font-weight:500;">Allow new user registrations</label>
        </div>

        <div class="form-group" style="display:flex;align-items:center;gap:.75rem;">
            <input type="checkbox" id="maintenance_mode" name="maintenance_mode"
                   <?= ($settings['maintenance_mode'] ?? '0') === '1' ? 'checked' : '' ?>
                   style="width:auto;accent-color:var(--danger);">
            <label for="maintenance_mode" style="margin:0;font-weight:500;color:var(--danger);">
                <i class="fas fa-exclamation-triangle"></i> Maintenance Mode (only admins can access)
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Settings</button>
            <a href="index.php?page=admin&action=index" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/../shared/footer.php'; ?>
