<?php
ob_start();

if (!Auth::isAdmin()) {
    header('Location: index.php');
    exit;
}

$orderDAO = new OrderDAO();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order'])) {
    $orderId = (int) $_POST['order_id'];
    $orderDAO->deleteOrderById($orderId);
    header('Location: index.php?page=admin');
    exit;
}

$orders = $orderDAO->getAllOrders();
?>

<h1>Gestion des Commandes</h1>
<h3>Liste des Commandes</h3>

<?php if (empty($orders)): ?>
    <p>Aucune commande n'a été trouvée.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Utilisateur</th>
            <th>Date</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order->getId() ?></td>
                <td><?= htmlspecialchars($order->getUsername()) ?></td>
                <td><?= date('d/m/Y', strtotime($order->getCreatedAt())) ?></td>
                <td><?= number_format($order->getTotal(), 2) ?> €</td>
                <td>
                    <button class="delete-order-btn" data-order-id="<?= $order->getId() ?>">
                        Supprimer
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<script src="/Project_Web_Aout/assets/js/manage_orders.js"></script>
