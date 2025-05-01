<?php
ob_start();
require_once __DIR__ . '/../../classes/auth.php';
require_once __DIR__ . '/../../classes/OrderDAO.php';

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
                <td><?= $order['id'] ?></td>
                <td><?= htmlspecialchars($order['username']) ?></td>
                <td><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                <td><?= number_format($order['total'], 2) ?> €</td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <button type="submit" name="delete_order">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
