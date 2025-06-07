<?php
require_once __DIR__ . '/../../Core/Auth.php';

if (!Auth::isConnected()) {
    header('Location: index.php?page=login');
    exit;
}

$user = Auth::getUser();
?>
<div class="account-info">
    <h1>Mon Compte</h1>

    <p>Nom d'utilisateur : <?= htmlspecialchars($user->username) ?></p>
    <p>Email : <?= htmlspecialchars($user->email) ?></p>

    <!-- Formulaire POST pour se déconnecter -->
    <form action="index.php?page=logout" method="POST">
        <button type="submit">Se déconnecter</button>
    </form>
</div>
