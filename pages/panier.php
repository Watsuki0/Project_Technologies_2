<?php
if (!Auth::isConnected()) {
    header('Location: index.php?page=login');
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = $_SESSION['cart'];
$gameDAO = new GameDAO();
$total = 0.0;
?>

<div class="cart-container">
    <h1>Mon Panier</h1>

    <?php if (empty($cart)): ?>
        <p>Votre panier est vide.</p>
    <?php else: ?>
        <table>
            <thead>
            <tr>
                <th>Jeu</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Sous-total</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cart as $gameId => $quantity):
                $game = $gameDAO->getGameById((int)$gameId);
                if ($game):
                    $subtotal = $game->price * (int)$quantity;
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($game->title) ?></td>
                        <td><?= number_format($game->price, 2, ',', ' ') ?> €</td>
                        <td>
                            <select class="quantity-select" data-game-id="<?= (int)$game->id ?>">
                                <?php for ($i = 1; $i <= 99; $i++): ?>
                                    <option value="<?= $i ?>" <?= $i == $quantity ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                        <td id="subtotal-<?= (int)$game->id ?>"><?= number_format($subtotal, 2, ',', ' ') ?> €</td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total : <span id="total-price"><?= number_format($total, 2, ',', ' ') ?> €</span></h3>

        <div class="cart-actions">
            <button type="button" id="checkout-btn">Valider la commande</button>
            <button type="button" id="clear-btn">Vider le panier</button>
        </div>
    <?php endif; ?>
</div>

<script src="/Project_Web_Aout/assets/js/panier.js"></script>
