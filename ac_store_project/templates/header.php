<?php
require_once __DIR__ . '/../includes/autoload.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AC Store</title>
    <link rel="stylesheet" href="assets/css/style.css">
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
                <li><a href="index.php?page=register">Inscription</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main>
    <?php // La page spécifique est incluse depuis index.php, donc pas besoin de gérer ici ?>
</main>
