<?php
require_once __DIR__ . '/../../Controllers/AdminController.php';

$adminController = new AdminController();
$data = $adminController->dashboard();

$users = $data['users'];
$orders = $data['orders'];
?>

<div class="admin-dashboard">
    <h1>Tableau de Bord</h1>

    <!-- LISTE DES UTILISATEURS -->
    <h3>Liste des Utilisateurs</h3>
    <table>
        <thead>
        <tr>
            <th>Nom d'utilisateur</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user->username) ?></td>
                <td><?= htmlspecialchars($user->email) ?></td>
                <td><?= $user->is_admin ? 'Admin' : 'Utilisateur' ?></td>
                <td>
                    <form method="post" action="?page=dashboard" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                        <input type="hidden" name="user_id" value="<?= $user->id ?>">
                        <button type="submit" name="delete_user">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- LISTE DES COMMANDES -->
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
                    <td><?= htmlspecialchars($order->id) ?></td>
                    <td><?= htmlspecialchars($order->username) ?></td>
                    <td><?= date('d/m/Y', strtotime($order->created_at)) ?></td>
                    <td><?= number_format($order->total, 2) ?> €</td>
                    <td>
                        <form method="post" action="?page=dashboard" onsubmit="return confirm('Voulez-vous vraiment supprimer cette commande ?');">
                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order->id) ?>">
                            <button type="submit" name="delete_order">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
