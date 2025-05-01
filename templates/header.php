<?php
require_once __DIR__ . '/../includes/autoload.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AC Store</title>
    <link rel="stylesheet" href="/SitePHP/Credo_site/ac_store_project/assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/c35aed3eb1.js" crossorigin="anonymous"></script>
</head>
<body>
<header>
    <h1><a href="index.php">Assassin's Creed Store</a></h1>
    <nav>
        <ul>
            <?php if (Auth::isConnected()): ?>
                <li><a href="index.php?page=cart"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a href="index.php?page=account"><i class="fa-solid fa-address-card"></i></a></li>
                <li><a href="index.php?page=logout"><i class="fa-solid fa-right-from-bracket"></i></a></li>
                <?php if (Auth::isAdmin()): ?>
                    <li><a href="index.php?page=admin"><i class="fa-solid fa-table-columns"></i></a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="index.php?page=login"><i class="fa-solid fa-right-to-bracket"></i></a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
