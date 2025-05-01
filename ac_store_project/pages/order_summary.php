<?php
if (!Auth::isConnected()) {
    header('Location: index.php?page=login');
    exit;
}

if (!isset($_GET['id'])) {
    echo "<p>Commande introuvable.</p>";
    return;
}

$orderId = (int) $_GET['id'];
$orderDAO = new OrderDAO();
$order = $orderDAO->getOrderById($orderId);


$orderItems = $orderDAO->getOrderItems($orderId);
?>
<div class="order-summary-container">
<h1>Récapitulatif de la commande</h1>

<p>Date de commande : <?= date('d/m/Y', strtotime($order['created_at'])) ?></p>


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
    <?php
    $total = 0;
    foreach ($orderItems as $item):
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
        ?>
        <tr>
            <td><?= htmlspecialchars($item['title']) ?></td>
            <td><?= number_format($item['price'], 2) ?> €</td>
            <td><?= $item['quantity'] ?></td>
            <td><?= number_format($subtotal, 2) ?> €</td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h3>Total de la commande : <?= number_format($total, 2) ?> €</h3>
</div>
