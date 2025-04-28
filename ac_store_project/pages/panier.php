<?php
if (!Auth::isConnected()) {
    header('Location: index.php?page=login');
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$gameDAO = new GameDAO();
$total = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['clear'])) {
        unset($_SESSION['cart']);
        header('Location: index.php?page=cart');
        exit;
    }
    if (isset($_POST['checkout'])) {
        $orderDAO = new OrderDAO();
        $userId = Auth::getUser()->id;

        if (!empty($cart)) {
            $orderDAO->createOrder($userId, $cart);
            unset($_SESSION['cart']);
            header('Location: index.php?page=account&success=1');
            exit;
        }
    }
}
?>

<h1>Mon Panier</h1>

<?php if (empty($cart)): ?>
    <p>Votre panier est vide.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Jeu</th>
            <th>Prix</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cart as $gameId):
            $game = $gameDAO->getGameById($gameId);
            if ($game): // Vérifie si le jeu existe dans la base
                $total += $game['price'];
                ?>
                <tr>
                    <td><?= htmlspecialchars($game['title']) ?></td>
                    <td><?= number_format($game['price'], 2) ?>€</td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Total : <?= number_format($total, 2) ?>€</h3>

    <form method="post">
        <button type="submit" name="checkout">Valider la commande</button>
        <button type="submit" name="clear">Vider le panier</button>
    </form>
<?php endif; ?>
