<?php
define('BASE_URL', '');
$pageTitle = htmlspecialchars($post['title']) . ' — UniStack';
require_once __DIR__ . '/header.php';
?>
<div style="max-width:720px;margin:0 auto;">
    <a href="index.php?page=home" class="btn btn-outline btn-sm" style="margin-bottom:1.5rem;">← Back to Browse</a>
    <div class="card" style="padding:2rem;">
        <span class="card-badge badge-<?= $post['type'] ?>">
            <?= $post['type']==='for_sale'?'🛒 For Sale':($post['type']==='housing'?'🏠 Housing':'📢 Announcement') ?>
        </span>
        <h1 style="font-size:1.6rem;margin-bottom:1rem;"><?= htmlspecialchars($post['title']) ?></h1>
        <?php if ($post['price'] > 0): ?>
            <div class="card-price" style="font-size:1.6rem;margin-bottom:1rem;"><?= number_format($post['price'], 0) ?> RWF</div>
        <?php endif; ?>
        <p style="line-height:1.7;color:#374151;margin-bottom:1.5rem;"><?= nl2br(htmlspecialchars($post['description'])) ?></p>
        <hr style="border:none;border-top:1px solid #e5e7eb;margin-bottom:1.5rem;">
        <div class="card-meta" style="font-size:.92rem;">
            👤 <strong><?= htmlspecialchars($post['author']) ?></strong> &nbsp;·&nbsp;
            🕐 <?= date('d M Y, H:i', strtotime($post['created_at'])) ?>
            <?php if ($post['contact']): ?>
                <br><br>📞 Contact: <strong><?= htmlspecialchars($post['contact']) ?></strong>
            <?php endif; ?>
        </div>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $post['user_id']): ?>
            <div style="margin-top:1.5rem;">
                <button class="btn btn-sm" style="background:#fee2e2;color:#991b1b;" onclick="openReportModal(<?= $post['id'] ?>)">🚩 Report This Post</button>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Report Modal -->
<div id="report-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;">
    <div style="background:white;padding:2rem;border-radius:12px;width:min(90%,420px);">
        <h3 style="margin-bottom:1rem;">🚩 Report This Post</h3>
        <form method="POST" action="index.php?page=posts&action=report">
            <input type="hidden" name="id" id="report-post-id">
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
