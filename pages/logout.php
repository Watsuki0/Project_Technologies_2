<?php
// Déconnexion de l'utilisateur dans le fichier Auth.php
Auth::logout();

// Redirection vers la page d'accueil
header('Location: index.php');
exit;

?>
