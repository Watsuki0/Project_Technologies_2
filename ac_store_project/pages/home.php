<?php
$gameDAO = new GameDAO();
$games = $gameDAO->getAllGames();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['add_to_cart'])) {
    $gameId = (int) $_GET['add_to_cart'];
    if (!in_array($gameId, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $gameId;
    }
    header('Location: index.php?page=cart');
    exit;
}
?>

<div class="games-grid">
    <?php foreach ($games as $game): ?>
        <div class="game-card">
            <?php
            $imageUrl = htmlspecialchars($game['image']);
            // Vérifie si c'est un lien complet ou un chemin local
            if (!preg_match('/^https?:\/\//', $imageUrl)) {
                $imageUrl = 'assets/images/' . $imageUrl;
            }
            ?>
            <h2><?= htmlspecialchars($game['title']) ?></h2>

            <a href="index.php?page=product&id=<?= $game['id'] ?>" class="btn"><img src="<?= $imageUrl ?>" alt="<?= htmlspecialchars($game['title']) ?>" style="width:200px;height:auto;"></a>

            <p><strong><?= number_format($game['price'], 2, ',', ' ') ?> €</strong></p>

            <a href="index.php?add_to_cart=<?= $game['id'] ?>"><i class="fa-solid fa-cart-plus"></i></a>
        </div>
    <?php endforeach; ?>
</div>
