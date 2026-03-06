<?php
define('BASE_URL', '');
$pageTitle = 'My Dashboard — UniStack';
require_once __DIR__ . '/../shared/header.php';
?>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
    <h2 class="section-title" style="border:none;padding:0;margin:0;"><i class="fas fa-hand-paper"></i> Welcome, <?= htmlspecialchars($_SESSION['name']) ?></h2>
    <a href="index.php?page=posts&action=create" class="btn btn-primary"><i class="fas fa-plus"></i> New Post</a>
</div>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-num"><?= $my['total'] ?></div>
        <div class="stat-label">Total Posts</div>
    </div>
    <div class="stat-card">
        <div class="stat-num" style="color:#16a34a;"><?= $my['approved'] ?></div>
        <div class="stat-label">Approved</div>
    </div>
    <div class="stat-card">
        <div class="stat-num" style="color:#d97706;"><?= $my['pending'] ?></div>
        <div class="stat-label">Pending</div>
    </div>
    <div class="stat-card">
        <div class="stat-num" style="color:#dc2626;"><?= $my['rejected'] ?></div>
        <div class="stat-label">Rejected</div>
    </div>
</div>

<!-- My Posts -->
<h3 class="section-title">My Posts</h3>

<?php if (empty($posts)): ?>
    <div class="empty-state">
        <div class="empty-icon">📝</div>
        <h3>No posts yet</h3>
        <p>Start by creating your first post!</p>
        <a href="index.php?page=posts&action=create" class="btn btn-primary" style="margin-top:1rem;"><i class="fas fa-plus"></i> Create Post</a>
    </div>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($post['title']) ?></strong></td>
                    <td>
                        <span class="card-badge badge-<?= $post['type'] ?>">
                            <?= ucfirst(str_replace('_',' ',$post['type'])) ?>
                        </span>
                    </td>
                    <td>
                        <span class="card-badge badge-<?= $post['status'] ?>">
                            <?= ucfirst($post['status']) ?>
                        </span>
                        <?php if ($post['is_flagged']): ?>
                            <span class="card-badge badge-flagged"><i class="fas fa-flag"></i> Flagged</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date('d M Y', strtotime($post['created_at'])) ?></td>
                    <td>
                        <div class="card-actions">
                            <a href="index.php?page=posts&action=edit&id=<?= $post['id'] ?>" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            <a href="index.php?page=posts&action=delete&id=<?= $post['id'] ?>"
                               class="btn btn-danger btn-sm"
                               data-confirm="Delete this post permanently?"><i class="fas fa-trash"></i> Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>
