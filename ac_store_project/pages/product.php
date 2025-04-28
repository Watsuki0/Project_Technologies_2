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

<h1><?= htmlspecialchars($game['title']) ?></h1>
<img src="assets/images/<?= htmlspecialchars($game['image']) ?>" alt="<?= htmlspecialchars($game['title']) ?>">
<p><?= htmlspecialchars($game['description']) ?></p>
<p><strong><?= number_format($game['price'], 2, ',', ' ') ?> €</strong></p>

<?php if (isset($_SESSION['user'])): ?>
    <form action="index.php?page=panier" method="post">
        <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
        <input type="number" name="quantity" value="1" min="1">
        <button type="submit">Ajouter au panier</button>
    </form>
<?php else: ?>
    <p><a href="index.php?page=login">Connectez-vous</a> pour ajouter au panier.</p>
<?php endif; ?>
