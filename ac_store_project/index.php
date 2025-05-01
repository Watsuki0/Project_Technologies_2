<?php
session_start();
require_once 'includes/autoload.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home'; // Page par défaut 'home'

// Sécurisation du chemin
$pagePath = 'pages/' . str_replace(['..', '/'], '', $page) . '.php';

require_once 'templates/header.php';

if ($page === 'cart' && file_exists('pages/panier.php')) {
    require_once 'pages/panier.php';
} elseif ($page === 'admin' && file_exists('pages/admin/dashboard.php')) {
    require_once 'pages/admin/dashboard.php';
} elseif (file_exists($pagePath)) {
    require_once $pagePath;
} elseif ($page === 'manage_games' && file_exists($pagePath)) {
    require_once 'pages/admin/manage_games.php';
} elseif ($page === 'manage_users' && file_exists($pagePath)) {
    require_once 'pages/admin/manage_users.php';
} elseif ($page === 'manage_orders' && file_exists($pagePath)) {
    require_once 'pages/admin/manage_users.php';
} else {
    echo "<h2>Page non trouvée</h2>";
}
// Inclure le footer
require_once 'templates/footer.php';
?>
