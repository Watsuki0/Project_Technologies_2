<?php
$gameDAO = new GameDAO();
$games = $gameDAO->getAllGames();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

?>
<div class="games-grid">
    <?php foreach ($games as $game): ?>
        <div class="game-card">
            <?php $imageUrl = htmlspecialchars($game->image); ?>
            <h2><?= htmlspecialchars($game->title) ?></h2>

            <a href="index.php?page=product&id=<?= $game->id ?>" class="btn">
                <img src="<?= $imageUrl ?>" alt="<?= htmlspecialchars($game->title) ?>" style="width:200px;height:auto;">
            </a>

            <p><strong><?= number_format($game->price, 2, ',', ' ') ?> €</strong></p>

            <!-- Remplacement du lien GET par un formulaire POST pour ajouter au panier -->
            <?php if (isset($_SESSION['user'])): ?>
                <form action="index.php?page=cart" method="post" style="display:inline;">
                    <input type="hidden" name="game_id" value="<?= $game->id ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button class="btn" type="submit" title="Ajouter au panier">
                        <i class="fa-solid fa-cart-plus"></i>
                    </button>
                </form>
            <?php else: ?>
                <a href="index.php?page=login" title="Connectez-vous pour ajouter au panier">
                    <i class="fa-solid fa-cart-plus"></i>
                </a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
