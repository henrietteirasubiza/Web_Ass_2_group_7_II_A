<?php
define('BASE_URL', '');
$pageTitle = 'Profile — UniStack';
require_once __DIR__ . '/header.php';
?>

<h2 class="section-title"><i class="fas fa-user"></i> My Profile</h2>

<div style="background:white;padding:2rem;border-radius:10px;border:1px solid #e5e7eb;box-shadow:0 2px 12px rgba(0,0,0,0.08);max-width:600px;">
    <div style="display:grid;gap:1.5rem;">
        <!-- Profile Info -->
        <div>
            <div style="margin-bottom:1rem;">
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
                    <div style="width:60px;height:60px;background:var(--primary);color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.8rem;font-weight:600;">
                        <?= htmlspecialchars(substr($user['name'],0,1)) ?>
                    </div>
                    <div>
                        <div style="font-size:1.2rem;font-weight:600;"><?= htmlspecialchars($user['name']) ?></div>
                        <div style="font-size:.9rem;color:#6b7280;"><?= htmlspecialchars($user['email']) ?></div>
                    </div>
                </div>
            </div>
            
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:1rem;">
                <div style="background:#f3f4f6;padding:1rem;border-radius:8px;text-align:center;">
                    <div style="font-size:.8rem;color:#6b7280;font-weight:500;margin-bottom:.25rem;"><i class="fas fa-shield-alt"></i> Role</div>
                    <div style="font-size:1.1rem;font-weight:600;"><?= ucfirst($user['role']) ?></div>
                </div>
                <?php if ($user['role'] === 'student'): ?>
                    <div style="background:#f3f4f6;padding:1rem;border-radius:8px;text-align:center;">
                        <div style="font-size:.8rem;color:#6b7280;font-weight:500;margin-bottom:.25rem;"><i class="fas fa-file-alt"></i> Posts</div>
                        <div style="font-size:1.1rem;font-weight:600;"><?= $post_count ?></div>
                    </div>
                <?php endif; ?>
                <div style="background:#f3f4f6;padding:1rem;border-radius:8px;text-align:center;">
                    <div style="font-size:.8rem;color:#6b7280;font-weight:500;margin-bottom:.25rem;"><i class="fas fa-calendar-alt"></i> Joined</div>
                    <div style="font-size:1.1rem;font-weight:600;"><?= date('M Y', strtotime($user['created_at'])) ?></div>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div style="border-top:1px solid #e5e7eb;padding-top:1.5rem;">
            <div style="margin-bottom:1rem;">
                <div style="font-size:.85rem;color:#6b7280;font-weight:600;margin-bottom:.5rem;"><i class="fas fa-envelope"></i> Email</div>
                <div style="font-size:.95rem;"><?= htmlspecialchars($user['email']) ?></div>
            </div>
            <div>
                <div style="font-size:.85rem;color:#6b7280;font-weight:600;margin-bottom:.5rem;"><i class="fas fa-qrcode"></i> User ID</div>
                <div style="font-size:.95rem;font-family:monospace;color:#6b7280;"><?= htmlspecialchars($user['id']) ?></div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div style="display:flex;gap:.75rem;margin-top:2rem;border-top:1px solid #e5e7eb;padding-top:1.5rem;flex-wrap:wrap;">
        <a href="index.php?page=profile&action=edit" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Profile</a>
        <a href="index.php?page=profile&action=changePassword" class="btn btn-primary"><i class="fas fa-lock"></i> Change Password</a>
        <a href="<?php if ($_SESSION['role'] === 'student') { echo 'index.php?page=student'; } elseif ($_SESSION['role'] === 'moderator') { echo 'index.php?page=moderator'; } else { echo 'index.php?page=admin'; } ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
