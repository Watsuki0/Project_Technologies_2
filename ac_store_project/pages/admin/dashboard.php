<?php
require_once __DIR__ . '/../../classes/auth.php';
// Vérifie si l'utilisateur est admin
if (!Auth::isAdmin()) {
    header('Location: ../../index.php'); // Attention au chemin de redirection
    exit;
}
require_once __DIR__ . '/../../classes/OrderDAO.php';
require_once __DIR__ . '/../../classes/UserDAO.php';
require_once __DIR__ . '/../../classes/GameDAO.php';

$orderDAO = new OrderDAO();
$userDAO = new UserDAO();
$gameDAO = new GameDAO();

// Récupère les statistiques
$totalOrders = $orderDAO->getTotalOrders();
$totalUsers = $userDAO->getTotalUsers();
$totalGames = $gameDAO->getTotalGames();
?>

<div class="admin-dashboard">
    <h1>Tableau de Bord</h1>
    <ul>
        <li>Nombre total de commandes : <?= $totalOrders ?></li>
        <li>Nombre total d'utilisateurs : <?= $totalUsers ?></li>
        <li>Nombre total de jeux : <?= $totalGames ?></li>
    </ul>

    <?php require_once 'manage_games.php'; ?>
    <?php require_once 'manage_users.php'; ?>
    <?php require_once 'manage_orders.php'; ?>
</div>
