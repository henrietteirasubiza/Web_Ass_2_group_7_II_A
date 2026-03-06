<?php
define('BASE_URL', '');
$pageTitle = 'Manage Users — UniStack';
require_once __DIR__ . '/../shared/header.php';
?>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
    <h2 class="section-title" style="border:none;padding:0;margin:0;">👥 Manage Users</h2>
    <a href="index.php?page=admin&action=index" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Registered</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><strong><?= htmlspecialchars($u['name']) ?></strong></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td>
                    <span class="card-badge" style="background:<?= $u['role']==='admin'?'#fde68a':($u['role']==='moderator'?'#dbeafe':'#d1fae5') ?>; color:#374151;">
                        <?= ucfirst($u['role']) ?>
                    </span>
                </td>
                <td>
                    <span class="card-badge <?= $u['is_active']?'badge-approved':'badge-rejected' ?>">
                        <?= $u['is_active']?'Active':'Disabled' ?>
                    </span>
                </td>
                <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                <td>
                    <?php if ($u['id'] != $_SESSION['user_id']): ?>
                        <a href="index.php?page=admin&action=toggle_user&id=<?= $u['id'] ?>"
                           class="btn btn-sm <?= $u['is_active']?'btn-danger':'btn-success' ?>"
                           data-confirm="<?= $u['is_active']?'Disable':'Enable' ?> this user?">
                            <?= $u['is_active']?'Disable':'Enable' ?>
                        </a>
                    <?php else: ?>
                        <span style="color:#9ca3af;font-size:.8rem;">You</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../shared/footer.php'; ?>
