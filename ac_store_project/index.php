<script src="https://kit.fontawesome.com/c35aed3eb1.js" crossorigin="anonymous"></script>

<?php
session_start();
require_once 'includes/autoload.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home'; // Page par défaut 'home'

// Sécurisation du chemin
$pagePath = 'pages/' . str_replace(['..', '/'], '', $page) . '.php';

require_once 'templates/header.php';

if ($page === 'cart' && file_exists('pages/panier.php')) {
    require_once 'pages/panier.php';
} elseif (file_exists($pagePath)) {
    require_once $pagePath;
} else {
    echo "<h2>Page non trouvée</h2>";
}

// Inclure le footer
require_once 'templates/footer.php';
?>
