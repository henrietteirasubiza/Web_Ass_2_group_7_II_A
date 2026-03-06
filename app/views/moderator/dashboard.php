<?php
define('BASE_URL', '');
$pageTitle = 'Moderator Panel — UniStack';
require_once __DIR__ . '/../shared/header.php';
?>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
    <h2 class="section-title" style="border:none;padding:0;margin:0;"><i class="fas fa-shield-alt"></i> Moderator Panel</h2>
    <a href="index.php?page=moderator&action=flags" class="btn btn-warning"><i class="fas fa-flag"></i> Flagged Posts</a>
</div>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-num" style="color:#d97706;"><?= $stats['pending'] ?></div>
        <div class="stat-label"><i class="fas fa-clock"></i> Pending Review</div>
    </div>
    <div class="stat-card">
        <div class="stat-num" style="color:#16a34a;"><?= $stats['approved'] ?></div>
        <div class="stat-label"><i class="fas fa-check-circle"></i> Approved</div>
    </div>
    <div class="stat-card">
        <div class="stat-num" style="color:#dc2626;"><?= $stats['rejected'] ?></div>
        <div class="stat-label"><i class="fas fa-times-circle"></i> Rejected</div>
    </div>
    <div class="stat-card">
        <div class="stat-num" style="color:#dc2626;"><?= $stats['flagged'] ?></div>
        <div class="stat-label"><i class="fas fa-flag"></i> Flagged</div>
    </div>
</div>

<!-- Pending Posts -->
<h3 class="section-title"><i class="fas fa-list"></i> Pending Posts (<?= count($pending) ?>)</h3>

<?php if (empty($pending)): ?>
    <div class="empty-state">
        <div class="empty-icon"><i class="fas fa-check"></i></div>
        <h3>All clear!</h3>
        <p>No posts waiting for review.</p>
    </div>
<?php else: ?>
    <div class="cards-grid">
    <?php foreach ($pending as $post): ?>
        <div class="card">
            <span class="card-badge badge-<?= $post['type'] ?>">
                <?= ucfirst(str_replace('_',' ',$post['type'])) ?>
            </span>
            <span class="card-badge badge-pending" style="margin-left:.3rem;">Pending</span>
            <h3><?= htmlspecialchars($post['title']) ?></h3>
            <p><?= htmlspecialchars(mb_substr($post['description'], 0, 150)) ?>...</p>
            <?php if ($post['price'] > 0): ?>
                <div class="card-price"><?= number_format($post['price'], 0) ?> RWF</div>
            <?php endif; ?>
            <div class="card-meta">
                👤 <?= htmlspecialchars($post['author']) ?> &nbsp;·&nbsp;
                🕐 <?= date('d M Y, H:i', strtotime($post['created_at'])) ?>
            </div>
            <div class="card-actions">
                <a href="index.php?page=moderator&action=approve&id=<?= $post['id'] ?>"
                   class="btn btn-success btn-sm"
                   data-confirm="Approve this post?">✅ Approve</a>
                <a href="index.php?page=moderator&action=reject&id=<?= $post['id'] ?>"
                   class="btn btn-danger btn-sm"
                   data-confirm="Reject this post?">❌ Reject</a>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>
