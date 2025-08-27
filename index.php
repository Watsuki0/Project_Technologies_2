<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AC Store</title>
    <link rel="stylesheet" href="/Project_Web_Aout/assets/css/style.css?v=<?= time() ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/c35aed3eb1.js" crossorigin="anonymous"></script>
</head>

<?php
session_start();
require_once 'includes/autoload.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home'; // Page par défaut 'home'

// Sécurisation du chemin
$pagePath = 'pages/' . str_replace(['..', '/'], '', $page) . '.php';

require_once 'templates/header.php';

if ($page === 'cart' && file_exists('pages/panier.php')) {
    require_once 'pages/panier.php';
} elseif ($page === 'admin' && file_exists('admin/dashboard.php')) {
    require_once 'admin/dashboard.php';
} elseif (file_exists($pagePath)) {
    require_once $pagePath;
} elseif ($page === 'manage_games' && file_exists($pagePath)) {
    require_once 'admin/manage_games.php';
} elseif ($page === 'manage_users' && file_exists($pagePath)) {
    require_once 'admin/manage_users.php';
} elseif ($page === 'manage_orders' && file_exists($pagePath)) {
    require_once 'admin/manage_users.php';
} else {
    echo "<h2>Page non trouvée</h2>";
}

require_once 'templates/footer.php';
?>
