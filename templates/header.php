<?php
require_once __DIR__ . '/../includes/autoload.php';
?>
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
