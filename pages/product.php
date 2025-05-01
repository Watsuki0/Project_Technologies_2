<?php
if (!isset($_GET['id'])) {
    echo "<h2>Jeu introuvable</h2>";
    return;
}

$gameDAO = new GameDAO();
$game = $gameDAO->getGameById($_GET['id']);

if (!$game) {
    echo "<h2>Jeu introuvable</h2>";
    return;
}
?>

<div class="product-container">
    <h1 class="product-title"><?= htmlspecialchars($game['title']) ?></h1>

    <div class="product-details">
        <div class="product-image">
            <img src="<?= htmlspecialchars($game['image']) ?>" alt="<?= htmlspecialchars($game['title']) ?>">
        </div>
        <div class="product-info">
            <p class="product-description"><?= nl2br(htmlspecialchars($game['description'])) ?></p>
            <p class="product-price"><?= number_format($game['price'], 2, ',', ' ') ?> €</p>

            <?php if (isset($_SESSION['user'])): ?>
                <form action="index.php?page=panier" method="post" class="product-form">
                    <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                    <label for="quantity">Quantité :</label>
                    <input type="number" name="quantity" value="1" min="1" id="quantity">
                    <button type="submit" class="btn">Ajouter au panier</button>
                </form>
            <?php else: ?>
                <p><a href="index.php?page=login">Connectez-vous</a> pour ajouter au panier.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
