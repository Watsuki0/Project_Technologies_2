<?php
// Vérifie si l'utilisateur est connecté
if (!Auth::isConnected()) {
    header('Location: index.php?page=login');
    exit;
}

// Récupère les informations de l'utilisateur
$user = Auth::getUser();
?>
<div class="account-info">
<h1>Mon Compte</h1>

<p>Nom d'utilisateur : <?= htmlspecialchars($user['username']) ?></p>
<p>Email : <?= htmlspecialchars($user['email']) ?></p>

<!-- Ajouter une option pour se déconnecter -->
<form action="index.php?page=logout" method="POST">
    <button type="submit">Se déconnecter</button>
</form>
</div>
