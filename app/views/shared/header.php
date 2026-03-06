<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $s = $GLOBALS['settings'] ?? []; ?>
    <title><?= $pageTitle ?? (htmlspecialchars($s['site_name'] ?? 'UniStack') . ' — ' . htmlspecialchars($s['site_tagline'] ?? 'INES Notice Board')) ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="<?= isset(
    	$_SESSION['user_id']
    ) ? 'logged-in' : '' ?>">
<nav class="navbar">
    <div class="nav-left">
        <?php if (isset($_SESSION['user_id'])): ?>
            <button class="sidebar-toggle" id="sidebar-toggle-btn" aria-label="Toggle sidebar"><i class="fas fa-bars"></i></button>
        <?php else: ?>
            <button class="nav-toggle" id="nav-toggle-btn" aria-label="Toggle menu"><i class="fas fa-bars"></i></button>
        <?php endif; ?>
    </div>
    <a href="index.php?page=home" class="nav-brand">
        <i class="fas fa-graduation-cap brand-icon"></i> <?= htmlspecialchars($s['site_name'] ?? 'UniStack') ?>
    </a>
    <div class="nav-right">
        <div class="nav-links" id="nav-menu">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="index.php?page=home" class="nav-link"><i class="fas fa-home"></i> Browse</a>
                <a href="index.php?page=auth&action=login" class="btn-nav"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="index.php?page=auth&action=register" class="btn-nav btn-primary"><i class="fas fa-user-plus"></i> Register</a>
            <?php else: ?>
                <form class="header-search" action="index.php" method="get" id="search-form">
                    <input type="hidden" name="page" value="home">
                    <div class="search-input-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" id="search-input" placeholder="Search posts..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" autocomplete="off">
                        <div id="search-suggestions" class="search-suggestions"></div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="header-user">
                <div class="avatar" id="avatar-btn" title="<?= htmlspecialchars($_SESSION['name']) ?>"><?= htmlspecialchars(substr($_SESSION['name'],0,1)) ?></div>
                <div class="avatar-menu" id="avatar-menu">
                    <div class="avatar-menu-header">
                        <div class="avatar-menu-name"><?= htmlspecialchars($_SESSION['name']) ?></div>
                        <div class="avatar-menu-role"><i class="fas fa-shield-alt"></i> <?= ucfirst($_SESSION['role']) ?></div>
                    </div>
                    <hr style="margin:.5rem 0;border:0;border-top:1px solid #e5e7eb;">
                    <a href="index.php?page=profile&action=view"><i class="fas fa-user"></i> Profile</a>
                    <a href="index.php?page=auth&action=logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</nav>
<?php if (isset($_SESSION['user_id'])): ?>
    <?php require_once __DIR__ . '/sidebar.php'; ?>
    <main class="main-content content-with-sidebar">
<?php else: ?>
    <main class="main-content">
<?php endif; ?>
<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
<?php endif; ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-error"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>
