<?php
define('BASE_URL', '');
$pageTitle = 'View Reports — UniStack';
require_once __DIR__ . '/../shared/header.php';
?>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
    <h2 class="section-title" style="border:none;padding:0;margin:0;">🚩 Reports for: <?= htmlspecialchars(mb_substr($post['title'], 0, 50)) ?></h2>
    <a href="index.php?page=moderator&action=flags" class="btn btn-outline btn-sm">← Back to Flags</a>
</div>

<!-- Post Info Card -->
<div style="background:white;padding:1.5rem;border-radius:10px;border:1px solid #e5e7eb;box-shadow:0 2px 12px rgba(0,0,0,0.08);margin-bottom:2rem;">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:1rem;">
        <div>
            <div style="font-size:.8rem;color:#6b7280;font-weight:500;">📝 Title</div>
            <div style="font-size:1rem;font-weight:600;margin-top:.25rem;"><?= htmlspecialchars($post['title']) ?></div>
        </div>
        <div>
            <div style="font-size:.8rem;color:#6b7280;font-weight:500;">👤 Author</div>
            <div style="font-size:1rem;font-weight:600;margin-top:.25rem;"><?= htmlspecialchars($post['author']) ?></div>
        </div>
        <div>
            <div style="font-size:.8rem;color:#6b7280;font-weight:500;">📊 Type</div>
            <div style="font-size:1rem;font-weight:600;margin-top:.25rem;"><span class="card-badge badge-<?= $post['type'] ?>"><?= ucfirst(str_replace('_', ' ', $post['type'])) ?></span></div>
        </div>
        <div>
            <div style="font-size:.8rem;color:#6b7280;font-weight:500;">🏷️ Status</div>
            <div style="font-size:1rem;font-weight:600;margin-top:.25rem;"><span class="card-badge badge-<?= $post['status'] ?>"><?= ucfirst($post['status']) ?></span></div>
        </div>
    </div>
</div>

<!-- Reports List -->
<h3 class="section-title">Reports (<?= count($reports) ?>)</h3>

<?php if (empty($reports)): ?>
    <div class="empty-state">
        <div class="empty-icon">✅</div>
        <h3>No reports</h3>
        <p>No one has reported this post.</p>
    </div>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Reporter</th>
                    <th>Reason</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($reports as $report): ?>
                <tr>
                    <td>
                        <strong><?= htmlspecialchars($report['reporter_name']) ?></strong>
                        <br>
                        <span style="font-size:.8rem;color:#6b7280;"><?= htmlspecialchars($report['reporter_email']) ?></span>
                    </td>
                    <td><?= htmlspecialchars($report['reason']) ?></td>
                    <td><?= date('d M Y, H:i', strtotime($report['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Actions -->
    <div style="display:flex;gap:.75rem;margin-top:2rem;flex-wrap:wrap;">
        <a href="index.php?page=moderator&action=approve&id=<?= $post['id'] ?>"
           class="btn btn-success"
           data-confirm="Keep this post? (Reports will remain logged)">✅ Keep Post</a>
        <a href="index.php?page=moderator&action=reject&id=<?= $post['id'] ?>"
           class="btn btn-danger"
           data-confirm="Remove this flagged post? (Action will be logged)">❌ Remove Post</a>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>
