<?php
// app/views/shared/sidebar.php
// Vertical navigation shown after login (role-specific)
?>
<aside class="sidebar">
    <a href="index.php?page=home"><i class="fas fa-home"></i> Browse</a>
    <?php if ($_SESSION['role'] === 'student'): ?>
        <a href="index.php?page=student"><i class="fas fa-chart-line"></i> My Dashboard</a>
        <a href="index.php?page=posts&action=create"><i class="fas fa-plus"></i> New Post</a>
    <?php elseif ($_SESSION['role'] === 'moderator'): ?>
        <a href="index.php?page=moderator&action=index"><i class="fas fa-shield-alt"></i> Mod Panel</a>
        <a href="index.php?page=moderator&action=flags"><i class="fas fa-flag"></i> Flagged Posts</a>
    <?php elseif ($_SESSION['role'] === 'admin'): ?>
        <a href="index.php?page=admin&action=index"><i class="fas fa-cog"></i> Admin Panel</a>
        <a href="index.php?page=admin&action=users"><i class="fas fa-users"></i> Users</a>
        <a href="index.php?page=admin&action=audit"><i class="fas fa-list"></i> Audit Log</a>
        <a href="index.php?page=admin&action=settings"><i class="fas fa-sliders-h"></i> Settings</a>
    <?php endif; ?>
    <hr>
    <span class="nav-user"><i class="fas fa-user-circle"></i> <?= htmlspecialchars($_SESSION['name']) ?></span>
    <a href="index.php?page=auth&action=logout" class="btn-nav btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
</aside>
