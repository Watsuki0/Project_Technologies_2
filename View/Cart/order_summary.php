<?php

require_once __DIR__ . '/../../DAO/OrderDAO.php';
require_once __DIR__ . '/../../Core/Auth.php';

if (!Auth::isConnected()) {
    header('Location: index.php?page=login');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>Commande introuvable.</p>";
    exit;
}

$orderId = (int)$_GET['id'];
$orderDAO = new OrderDAO();

$order = $orderDAO->getOrderById($orderId);

if (!$order) {
    echo "<p>Commande introuvable.</p>";
    exit;
}
$userId = Auth::getUser()->id;

$orderItems = $orderDAO->getOrderItems($orderId);

$total = 0;
?>

<div class="order-summary-container">
    <h1>Récapitulatif de la commande</h1>

    <p><strong>Date de commande :</strong> <?= date('d/m/Y', strtotime($order->created_at)) ?></p>
    <p><strong>Statut :</strong> <?= htmlspecialchars($order->status ?? 'En cours') ?></p>

    <?php if (empty($orderItems)): ?>
        <p>Aucun article dans cette commande.</p>
    <?php else: ?>
        <table>
            <thead>
            <tr>
                <th>Jeu</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Sous-total</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orderItems as $item):
                $subtotal = $item->price * $item->quantity;
                $total += $subtotal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item->title) ?></td>
                    <td><?= number_format($item->price, 2) ?> €</td>
                    <td><?= (int)$item->quantity ?></td>
                    <td><?= number_format($subtotal, 2) ?> €</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total de la commande : <?= number_format($total, 2) ?> €</h3>
    <?php endif; ?>

    <p><a href="index.php">Retour à la page d'accueil</a></p>
</div>
