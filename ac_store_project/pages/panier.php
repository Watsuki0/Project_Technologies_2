<?php
if (!Auth::isConnected()) {
    header('Location: index.php?page=login');
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['game_id'], $_POST['quantity'])) {
        $gameId = (int) $_POST['game_id'];
        $quantity = (int) $_POST['quantity'];

        if ($quantity > 0) {
            if (isset($_SESSION['cart'][$gameId])) {
                $_SESSION['cart'][$gameId] += $quantity;
            } else {
                $_SESSION['cart'][$gameId] = $quantity;
            }
        }

        header('Location: index.php?page=cart');
        exit;
    }
    $userId = Auth::getUser()['id'];
    $cartDAO = new OrderDAO();

    if (isset($_POST['clear'])) {
        unset($_SESSION['cart']);
        header('Location: index.php?page=cart');
        exit;
    }

    if (isset($_POST['checkout'])) {
        $orderDAO = new OrderDAO();
        try {
            if (!empty($_SESSION['cart'])) {
                $orderId = $orderDAO->createOrder($userId, $_SESSION['cart']);
                unset($_SESSION['cart']);
                header("Location: index.php?page=order_summary&id=$orderId");
                exit;
            } else {
                $error = "Votre panier est vide.";
            }
        } catch (Exception $e) {
            $error = "Erreur lors de la commande : " . $e->getMessage();
        }
    }

    if (isset($_POST['update_quantity'], $_POST['game_id'])) {
        $gameId = (int) $_POST['game_id'];
        $newQuantity = (int) $_POST['update_quantity'];
        if ($newQuantity > 0) {
            $_SESSION['cart'][$gameId] = $newQuantity;
        }
        header('Location: index.php?page=cart');
        exit;
    }

    if (isset($_POST['delete_item'], $_POST['game_id'])) {
        $gameId = (int) $_POST['game_id'];
        unset($_SESSION['cart'][$gameId]);
        $cartDAO->deleteCartItem($userId, $gameId); // Doit exister
        header('Location: index.php?page=cart');
        exit;
    }
}

$cart = $_SESSION['cart'];
$gameDAO = new GameDAO();
$total = 0;
?>

<div class="cart-container">
    <h1>Mon Panier</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

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
                $game = $gameDAO->getGameById($gameId);
                if ($game):
                    $subtotal = $game['price'] * $quantity;
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($game['title']) ?></td>
                        <td><?= number_format($game['price'], 2) ?> €</td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="game_id" value="<?= $gameId ?>">
                                <select name="update_quantity" onchange="this.form.submit()">
                                    <?php for ($i = 1; $i <= 99; $i++): ?>
                                        <option value="<?= $i ?>" <?= $i == $quantity ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </form>
                        </td>
                        <td><?= number_format($subtotal, 2) ?> €</td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total : <?= number_format($total, 2) ?> €</h3>

        <form method="post">
            <button type="submit" name="checkout">Valider la commande</button>
            <button type="submit" name="clear">Vider le panier</button>
        </form>
    <?php endif; ?>
</div>
