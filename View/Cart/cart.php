<?php

require_once __DIR__ . '/../../Models/Game.php';
require_once __DIR__ . '/../../DAO/GameDAO.php';
require_once __DIR__ . '/../../Controllers/CartController.php';
require_once __DIR__ . '/../../DAO/OrderDAO.php';
require_once __DIR__ . '/../../Core/Auth.php';

if (!Auth::isConnected()) {
    header('Location: index.php?page=login');
    exit;
}

$cartController = new CartController();
$gameDAO = new GameDAO();
$orderDAO = new OrderDAO();
$userId = Auth::getUser()->id;
$error = null;

// Gère les requêtes POST (ajout, suppression, mise à jour, commande, vider)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ajouter au panier
    if (isset($_POST['game_id'], $_POST['quantity'])) {
        $gameId = (int)$_POST['game_id'];
        $quantity = max(1, (int)$_POST['quantity']);
        $cartController->addToCart($gameId, $quantity);
        header('Location: index.php?page=cart');
        exit;
    }

    // Vider le panier
    if (isset($_POST['clear'])) {
        $cartController->clearCart();
        header('Location: index.php?page=cart');
        exit;
    }

    // Valider la commande
    if (isset($_POST['checkout'])) {
        $cartItems = $_SESSION['cart'] ?? [];
        if (!empty($cartItems)) {
            try {
                $orderId = $orderDAO->createOrder($userId, $cartItems);
                $cartController->clearCart();
                header("Location: index.php?page=order_summary&id=$orderId");
                exit;
            } catch (Exception $e) {
                $error = "Erreur lors de la commande : " . $e->getMessage();
            }
        } else {
            $error = "Votre panier est vide.";
        }
    }

    // Mettre à jour la quantité d’un article
    if (isset($_POST['update_quantity'], $_POST['game_id'])) {
        $gameId = (int)$_POST['game_id'];
        $newQty = (int)$_POST['update_quantity'];
        if ($newQty > 0) {
            $cartController->updateQuantities([$gameId => $newQty]);
        } else {
            $cartController->removeFromCart($gameId);
        }
        header('Location: index.php?page=cart');
        exit;
    }

    // Supprimer un article
    if (isset($_POST['delete_item'], $_POST['game_id'])) {
        $gameId = (int)$_POST['game_id'];
        $cartController->removeFromCart($gameId);
        header('Location: index.php?page=cart');
        exit;
    }
}

// Récupérer les items complets
$cartItems = $cartController->getCartItems();
$total = $cartController->getTotal();
?>

<div class="cart-container">
    <h1>Mon Panier</h1>

    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>
        <p>Votre panier est vide.</p>
    <?php else: ?>
        <table>
            <thead>
            <tr>
                <th>Jeu</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Sous-total</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['game']->title) ?></td>
                    <td><?= number_format($item['game']->price, 2) ?> €</td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="game_id" value="<?= $item['game']->id ?>">
                            <select name="update_quantity" onchange="this.form.submit()">
                                <?php for ($i = 1; $i <= 99; $i++): ?>
                                    <option value="<?= $i ?>" <?= $i === $item['quantity'] ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </form>
                    </td>
                    <td><?= number_format($item['total_price'], 2) ?> €</td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="game_id" value="<?= $item['game']->id ?>">
                            <button type="submit" name="delete_item" onclick="return confirm('Supprimer cet article ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total : <?= number_format($total, 2) ?> €</h3>

        <form method="post">
            <button type="submit" name="checkout">Valider la commande</button>
            <button type="submit" name="clear" onclick="return confirm('Vider tout le panier ?')">Vider le panier</button>
        </form>
    <?php endif; ?>
</div>
