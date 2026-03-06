<?php
// public/index.php — Front Controller (Router)
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../app/models/Settings.php';

// Load site settings globally
$_settingsModel = new Settings($conn);
$GLOBALS['settings'] = $_settingsModel->getAll();
$settings = $GLOBALS['settings'];

// Maintenance mode: block non-admins
if (($settings['maintenance_mode'] ?? '0') === '1' && ($_SESSION['role'] ?? '') !== 'admin') {
    http_response_code(503);
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Maintenance</title>
    <style>body{font-family:sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;background:#051642ec;color:#fff;text-align:center;}
    .box{padding:3rem;}.icon{font-size:4rem;margin-bottom:1rem;}.h1{font-size:2rem;margin-bottom:.5rem;}</style></head>
    <body><div class="box"><div class="icon">🔧</div><div class="h1">' . htmlspecialchars($settings['site_name'] ?? 'UniStack') . '</div>
    <p>We are currently under maintenance. Please check back soon.</p></div></body></html>';
    exit;
}

// Simple router
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Search API endpoint for autocomplete
if ($page === 'api' && $action === 'search') {
    header('Content-Type: application/json');
    $query = trim($_GET['q'] ?? '');
    
    if (strlen($query) >= 2) {
        $result = $conn->query("SELECT id, title, type FROM posts WHERE status='approved' AND (title LIKE '%$query%' OR description LIKE '%$query%') LIMIT 5");
        $posts = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($posts);
    } else {
        echo json_encode([]);
    }
    exit;
}

// Simple router
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Auth guard helper
function requireAuth($role = null) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?page=auth&action=login');
        exit;
    }
    if ($role && $_SESSION['role'] !== $role) {
        // Allow admin access everywhere
        if ($_SESSION['role'] !== 'admin') {
            header('Location: index.php?page=home&error=unauthorized');
            exit;
        }
    }
}

switch ($page) {
    case 'home':
        require_once __DIR__ . '/../app/controllers/HomeController.php';
        $ctrl = new HomeController($conn);
        $ctrl->index();
        break;

    case 'auth':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $ctrl = new AuthController($conn);
        if ($action === 'login') $ctrl->login();
        elseif ($action === 'register') {
            if (($settings['allow_registration'] ?? '1') === '0') {
                header('Location: index.php?page=auth&action=login&error=Registration is currently disabled.');
                exit;
            }
            $ctrl->register();
        }
        elseif ($action === 'logout') $ctrl->logout();
        break;

    case 'posts':
        require_once __DIR__ . '/../app/controllers/PostController.php';
        $ctrl = new PostController($conn);
        if ($action === 'index') $ctrl->index();
        elseif ($action === 'create') { requireAuth('student'); $ctrl->create(); }
        elseif ($action === 'store') { requireAuth('student'); $ctrl->store(); }
        elseif ($action === 'edit') { requireAuth('student'); $ctrl->edit(); }
        elseif ($action === 'update') { requireAuth('student'); $ctrl->update(); }
        elseif ($action === 'delete') { requireAuth('student'); $ctrl->delete(); }
        elseif ($action === 'report') { requireAuth(); $ctrl->report(); }
        elseif ($action === 'view') $ctrl->view();
        break;

    case 'profile':
        requireAuth();
        require_once __DIR__ . '/../app/controllers/ProfileController.php';
        $ctrl = new ProfileController($conn);
        if ($action === 'view') $ctrl->view();
        elseif ($action === 'edit') $ctrl->edit();
        elseif ($action === 'update') $ctrl->update();
        elseif ($action === 'changePassword') $ctrl->changePassword();
        elseif ($action === 'updatePassword') $ctrl->updatePassword();
        break;

    case 'student':
        requireAuth('student');
        require_once __DIR__ . '/../app/controllers/StudentController.php';
        $ctrl = new StudentController($conn);
        $ctrl->dashboard();
        break;

    case 'moderator':
        requireAuth('moderator');
        require_once __DIR__ . '/../app/controllers/ModeratorController.php';
        $ctrl = new ModeratorController($conn);
        if ($action === 'index') $ctrl->dashboard();
        elseif ($action === 'approve') $ctrl->approve();
        elseif ($action === 'reject') $ctrl->reject();
        elseif ($action === 'flags') $ctrl->flags();
        elseif ($action === 'viewReports') $ctrl->viewReports();
        break;

    case 'admin':
        requireAuth('admin');
        require_once __DIR__ . '/../app/controllers/AdminController.php';
        $ctrl = new AdminController($conn);
        if ($action === 'index') $ctrl->dashboard();
        elseif ($action === 'users') $ctrl->users();
        elseif ($action === 'toggle_user') $ctrl->toggleUser();
        elseif ($action === 'delete_post') $ctrl->deletePost();
        elseif ($action === 'audit') $ctrl->audit();
        elseif ($action === 'viewReports') $ctrl->viewReports();
        elseif ($action === 'settings') $ctrl->settings();
        elseif ($action === 'save_settings') $ctrl->saveSettings();
        break;

    default:
        require_once __DIR__ . '/../app/controllers/HomeController.php';
        $ctrl = new HomeController($conn);
        $ctrl->index();
}
