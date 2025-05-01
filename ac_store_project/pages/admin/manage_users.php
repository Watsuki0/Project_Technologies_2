<?php
ob_start();
require_once __DIR__ . '/../../classes/auth.php';
require_once __DIR__ . '/../../classes/UserDAO.php';

if (!Auth::isAdmin()) {
    header('Location: index.php');
    exit;
}

$userDAO = new UserDAO();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $userId = (int) $_POST['user_id'];
    $userDAO->deleteUser($userId);
    header('Location: index.php?page=admin');
    exit;
}

$users = $userDAO->getAllUsers();
?>

<h1>Gestion des Utilisateurs</h1>
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
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= $user['is_admin'] ? 'Admin' : 'Utilisateur' ?></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                    <button type="submit" name="delete_user">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
