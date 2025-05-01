<?php
ob_start();
require_once __DIR__ . '/../../classes/auth.php';
require_once __DIR__ . '/../../classes/GameDAO.php';

if (!Auth::isAdmin()) {
    header('Location: index.php');
    exit;
}

$gameDAO = new GameDAO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_game'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = (float) $_POST['price'];
        $image = $_POST['image'];

        $gameDAO->addGame($title, $description, $price, $image);
        header('Location: index.php?page=admin');
        exit;
    } elseif (isset($_POST['delete_game'])) {
        $gameId = (int) $_POST['game_id'];
        $gameDAO->deleteGame($gameId);
        header('Location: index.php?page=admin');
        exit;
    }
}

$games = $gameDAO->getAllGames();
?>

<h1>Gestion des Jeux</h1>
<form method="post" id="add_game_form">
    <h3>Ajouter un Nouveau Jeu</h3>
    <input type="text" name="title" placeholder="Titre" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="number" step="0.01" name="price" placeholder="Prix" required>
    <input type="text" name="image" placeholder="URL de l'image" required>
    <button type="submit" name="add_game">Ajouter</button>
</form>

<h3>Liste des Jeux</h3>
<table>
    <thead>
    <tr>
        <th>Titre</th>
        <th>Description</th>
        <th>Prix</th>
        <th>Image</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($games as $game): ?>
        <tr>
            <td><?= htmlspecialchars($game['title']) ?></td>
            <td><?= htmlspecialchars($game['description']) ?></td>
            <td><?= number_format($game['price'], 2) ?> €</td>
            <td><img src="<?= htmlspecialchars($game['image']) ?>" alt="Image" width="50"></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                    <button type="submit" name="delete_game">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
