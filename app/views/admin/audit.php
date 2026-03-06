<?php
define('BASE_URL', '');
$pageTitle = 'Audit Log — UniStack';
require_once __DIR__ . '/../shared/header.php';
?>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
    <h2 class="section-title" style="border:none;padding:0;margin:0;">📋 Audit Log</h2>
    <a href="index.php?page=admin&action=index" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Email</th>
                <th>Action</th>
                <th>Post ID</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($logs)): ?>
            <tr><td colspan="6" style="text-align:center;color:#9ca3af;padding:2rem;">No log entries yet.</td></tr>
        <?php else: ?>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= $log['id'] ?></td>
                    <td><strong><?= htmlspecialchars($log['name']) ?></strong></td>
                    <td><?= htmlspecialchars($log['email']) ?></td>
                    <td><?= htmlspecialchars($log['action']) ?></td>
                    <td><?= $log['target_id'] ?? '—' ?></td>
                    <td><?= date('d M Y, H:i:s', strtotime($log['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../shared/footer.php'; ?>
