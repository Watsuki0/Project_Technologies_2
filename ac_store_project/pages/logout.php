<?php
// Déconnexion de l'utilisateur
Auth::logout();

// Redirection vers la page d'accueil
header('Location: index.php');
exit;
?>
