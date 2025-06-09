<?php
require_once __DIR__ . '/../../Core/Auth.php';
require_once __DIR__ . '/../../DAO/UserDAO.php';

if (Auth::isConnected()) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userDAO = new UserDAO();
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide.";
    } elseif (!$username || !$email || !$password) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        // Optionnel : vérifier si email ou username existe déjà (à ajouter dans UserDAO)
        $successRegister = $userDAO->register($username, $email, $password);
        if ($successRegister) {
            $success = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
        } else {
            $error = "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    }
}
?>
<div class="auth-container">
    <h1>Inscription</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php elseif ($success): ?>
        <p style="color:green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Nom d'utilisateur :</label><br>
        <input type="text" name="username" required><br><br>

        <label>Email :</label><br>
        <input type="email" name="email" required><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br><br>

        <label>Confirmer le mot de passe :</label><br>
        <input type="password" name="confirm_password" required><br><br>

        <button type="submit">S'inscrire</button>
    </form>

    <p>Déjà un compte ? <a href="index.php?page=login">Connectez-vous</a></p>
</div>
