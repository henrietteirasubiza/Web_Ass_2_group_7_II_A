<?php
define('BASE_URL', '');
$pageTitle = 'Flagged Posts — UniStack';
require_once __DIR__ . '/../shared/header.php';
?>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
    <h2 class="section-title" style="border:none;padding:0;margin:0;"><i class="fas fa-flag"></i> Flagged Posts</h2>
    <a href="index.php?page=moderator&action=index" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back to Panel</a>
</div>

<?php if (empty($flagged)): ?>
    <div class="empty-state">
        <div class="empty-icon"><i class="fas fa-flag" style="opacity:.3;"></i></div>
        <h3>No flagged posts</h3>
        <p>No posts have been reported by students.</p>
    </div>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Type</th>
                    <th>Reports</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($flagged as $post): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($post['title']) ?></strong></td>
                    <td><?= htmlspecialchars($post['author']) ?></td>
                    <td><span class="card-badge badge-<?= $post['type'] ?>"><i class="fas fa-tag"></i> <?= ucfirst(str_replace('_',' ',$post['type'])) ?></span></td>
                    <td><span style="color:#dc2626;font-weight:700;"><i class="fas fa-exclamation-circle"></i> <?= $post['report_count'] ?></span></td>
                    <td><span class="card-badge badge-<?= $post['status'] ?>"><?= ucfirst($post['status']) ?></span></td>
                    <td>
                        <div class="card-actions">
                            <a href="index.php?page=moderator&action=viewReports&id=<?= $post['id'] ?>" class="btn btn-outline btn-sm">👁️ View Reports</a>
                            <a href="index.php?page=moderator&action=reject&id=<?= $post['id'] ?>"
                               class="btn btn-danger btn-sm"
                               data-confirm="Reject and hide this flagged post?">Remove</a>
                            <a href="index.php?page=moderator&action=approve&id=<?= $post['id'] ?>"
                               class="btn btn-outline btn-sm">Keep</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
<?php require_once __DIR__ . '/../shared/footer.php'; ?>
