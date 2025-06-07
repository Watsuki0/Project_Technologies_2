<?php
session_start();
require_once 'includes/autoload.php';

$page = $_GET['page'] ?? 'home';

// Liste blanche des pages autorisées (pour éviter inclusion arbitraire)
$allowedPages = [
    '404',
    'home',
    'product',
    'login',
    'logout',
    'register',
    'account',
    'cart',
    'order_summary',
    // Admin pages
    'dashboard',
    'manage_games',
    'manage_users',
    'manage_orders',
    // AJAX pages pour admin (important de les lister ici)
    'ajax_get_games_list',
    'ajax_get_users_list',
    'ajax_get_orders_list',
];

$adminPages = ['dashboard'];
$adminAjaxPages = ['ajax_get_games_list', 'ajax_get_users_list', 'ajax_get_orders_list'];
$accountPages = ['account', 'login', 'logout', 'register'];
$cartPages = ['cart', 'order_summary'];
$homePages = ['home', 'product'];

// Vérification page valide
if (!in_array($page, $allowedPages)) {
    http_response_code(404);
    $page = '404';
}

require_once 'templates/header.php';

if (in_array($page, $adminPages)) {
$file = "View/Admin/{$page}.php";
if (file_exists($file)) {
    require_once $file;
} else {
    echo "<h2>Page non trouvée</h2>";
}
} elseif (in_array($page, $accountPages)) {
    $file = "View/Account/{$page}.php";
    if (file_exists($file)) {
        require_once $file;
    } else {
        echo "<h2>Page non trouvée</h2>";
    }
} elseif (in_array($page, $cartPages)) {
    $file = "View/Cart/{$page}.php";
    if (file_exists($file)) {
        require_once $file;
    } else {
        echo "<h2>Page non trouvée</h2>";
    }
} elseif (in_array($page, $homePages)) {
    $file = "View/Home/{$page}.php";
    if (file_exists($file)) {
        require_once $file;
    } else {
        echo "<h2>Page non trouvée</h2>";
    }
} else {
    echo "<h2>Page non trouvée</h2>";
}

require_once 'templates/footer.php';
