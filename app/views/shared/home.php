<?php
define('BASE_URL', '');
$pageTitle = 'Browse — UniStack';
$currentType = $_GET['type'] ?? '';
$currentSearch = $_GET['search'] ?? '';
require_once __DIR__ . '/header.php';
?>

<div class="hero">
    <h1><i class="fas fa-graduation-cap"></i> INES Notice Board & Marketplace</h1>
    <p>Buy, sell, find housing, and stay updated — all in one safe student space.</p>
    <form class="search-bar" method="GET" action="index.php">
        <input type="hidden" name="page" value="home">
        <?php if (isset($_GET['all']) && $_GET['all'] === '1'): ?>
            <input type="hidden" name="all" value="1">
        <?php endif; ?>
        <input type="text" name="search" placeholder="Search posts" value="<?= htmlspecialchars($currentSearch) ?>">
        <select name="type">
            <option value="">All Categories</option>
            <option value="for_sale" <?= $currentType==='for_sale'?'selected':'' ?>>🛒 For Sale</option>
            <option value="housing" <?= $currentType==='housing'?'selected':'' ?>>🏠 Housing</option>
            <option value="announcement" <?= $currentType==='announcement'?'selected':'' ?>>📢 Announcements</option>
        </select>
        <button type="submit" class="btn btn-primary">Search</button>
        <?php if ($currentSearch || $currentType): ?>
            <a href="index.php?page=home" class="btn btn-outline" style="border-color:rgba(255,255,255,.5);color:white;">Clear</a>
        <?php endif; ?>
    </form>
</div>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
    <span class="section-title"><i class="fas fa-newspaper"></i> Latest Posts</span>
    <span style="font-size:.83rem;color:#6b7280;">
        <span class="polling-dot"></span> Auto-refreshing every 10s
    </span>
</div>

<div id="posts-container">
<?php if (empty($posts)): ?>
    <div class="empty-state">
        <div class="empty-icon">📭</div>
        <h3>No posts found</h3>
        <p>Try a different search or check back later.</p>
    </div>
<?php else: ?>
    <div class="cards-grid">
    <?php foreach ($posts as $post): ?>
        <div class="card">
            <span class="card-badge badge-<?= $post['type'] ?>">
                <?php 
                if ($post['type'] === 'for_sale') echo '<i class="fas fa-shopping-cart"></i> For Sale';
                elseif ($post['type'] === 'housing') echo '<i class="fas fa-home"></i> Housing';
                else echo '<i class="fas fa-bullhorn"></i> Announcement';
                ?>
            </span>
            <?php if (isset($_SESSION['role']) && $_SESSION['role']==='admin' && isset($_GET['all']) && $_GET['all']=='1'): ?>
                <span class="card-badge badge-<?= $post['status'] ?>" style="margin-left:.3rem;">
                    <?= ucfirst($post['status']) ?>
                </span>
            <?php endif; ?>
            <h3><?= htmlspecialchars($post['title']) ?></h3>
            <p><?= htmlspecialchars(mb_substr($post['description'], 0, 120)) . (mb_strlen($post['description'])>120?'...':'') ?></p>
            <?php if ($post['price'] > 0): ?>
                <div class="card-price"><?= number_format($post['price'], 0) ?> RWF</div>
            <?php endif; ?>
            <div class="card-meta">
                <i class="fas fa-user"></i> <?= htmlspecialchars($post['author']) ?> &nbsp;·&nbsp;
                <i class="fas fa-calendar-alt"></i> <?= date('d M Y', strtotime($post['created_at'])) ?>
                <?php if ($post['contact']): ?>
                    &nbsp;·&nbsp; <i class="fas fa-phone"></i> <?= htmlspecialchars($post['contact']) ?>
                <?php endif; ?>
            </div>
            <div class="card-actions">
                <a href="index.php?page=posts&action=view&id=<?= $post['id'] ?>" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i> View</a>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $post['user_id']): ?>
                    <button class="btn btn-sm" style="background:#fee2e2;color:#991b1b;" onclick="openReportModal(<?= $post['id'] ?>)"><i class="fas fa-flag"></i> Report</button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>
</div>

<!-- Report Modal -->
<div id="report-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;">
    <div style="background:white;padding:2rem;border-radius:12px;width:min(90%,420px);">
        <h3 style="margin-bottom:1rem;"><i class="fas fa-flag"></i> Report This Post</h3>
        <form method="POST" action="index.php?page=posts&action=report">
            <input type="hidden" name="id" id="report-post-id">
            <input type="hidden" name="page" value="home">
            <div class="form-group">
                <label>Reason</label>
                <select name="reason" style="width:100%;padding:.6rem;border:2px solid #e5e7eb;border-radius:7px;">
                    <option>Scam or Fraud</option>
                    <option>Inappropriate Content</option>
                    <option>Spam</option>
                    <option>Wrong Category</option>
                    <option>Other</option>
                </select>
            </div>
            <div style="display:flex;gap:.5rem;justify-content:flex-end;margin-top:1rem;">
                <button type="button" class="btn btn-outline" onclick="closeReportModal()">Cancel</button>
                <button type="submit" class="btn btn-danger">Submit Report</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
