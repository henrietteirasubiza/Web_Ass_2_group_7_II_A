<?php
define('BASE_URL', '');
$pageTitle = 'Admin Dashboard — UniStack';
require_once __DIR__ . '/../shared/header.php';
?>
<h2 class="section-title"><i class="fas fa-cog"></i> Admin Dashboard</h2>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-num"><?= $stats['students'] ?></div>
        <div class="stat-label"><i class="fas fa-users"></i> Students</div>
    </div>
    <div class="stat-card">
        <div class="stat-num" style="color:#16a34a;"><?= $stats['approved'] ?></div>
        <div class="stat-label"><i class="fas fa-check-circle"></i> Live Posts</div>
    </div>
    <div class="stat-card">
        <div class="stat-num" style="color:#d97706;"><?= $stats['pending'] ?></div>
        <div class="stat-label"><i class="fas fa-clock"></i> Pending</div>
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

<!-- Quick Links -->
<div style="display:flex;gap:.75rem;margin-bottom:2rem;flex-wrap:wrap;">
    <a href="index.php?page=admin&action=users" class="btn btn-primary"><i class="fas fa-users"></i> Manage Users</a>
    <a href="index.php?page=admin&action=audit" class="btn btn-outline"><i class="fas fa-list"></i> Audit Log</a>
    <a href="index.php?page=moderator&action=index" class="btn btn-outline"><i class="fas fa-shield-alt"></i> Mod Queue</a>
</div>

<!-- All Posts -->
<h3 class="section-title"><i class="fas fa-newspaper"></i> All Posts</h3>
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Type</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($posts as $post): ?>
            <tr>
                <td><?= htmlspecialchars(mb_substr($post['title'],0,50)) ?></td>
                <td><?= htmlspecialchars($post['author']) ?></td>
                <td><span class="card-badge badge-<?= $post['type'] ?>"><?= ucfirst(str_replace('_',' ',$post['type'])) ?></span></td>
                <td>
                    <span class="card-badge badge-<?= $post['status'] ?>"><?= ucfirst($post['status']) ?></span>
                    <?php if ($post['is_flagged']): ?><span class="card-badge badge-flagged">🚩</span><?php endif; ?>
                </td>
                <td><?= date('d M Y', strtotime($post['created_at'])) ?></td>
                <td>
                    <?php if ($post['is_flagged']): ?>
                        <a href="index.php?page=admin&action=viewReports&id=<?= $post['id'] ?>" class="btn btn-outline btn-sm">🚩 Reports</a>
                    <?php else: ?>
                        <a href="index.php?page=admin&action=delete_post&id=<?= $post['id'] ?>"
                           class="btn btn-danger btn-sm"
                           data-confirm="Permanently delete this post?">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../shared/footer.php'; ?>
