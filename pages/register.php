<?php
if (Auth::isConnected()) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Vérifications
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        try {
            // Créer l'objet User avec le mot de passe fourni
            $user = new User(null, $username, $email, $password, false);
            $userDAO = new UserDAO();
            $userDAO->register($user, $password);

            $success = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
        } catch (Exception $e) {
            $error = "Erreur lors de l'inscription : " . $e->getMessage();
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
        <label>
            <input type="text" name="username" required>
        </label><br><br>

        <label>Email :</label><br>
        <label>
            <input type="email" name="email" required>
        </label><br><br>

        <label>Mot de passe :</label><br>
        <label>
            <input type="password" name="password" required>
        </label><br><br>

        <label>Confirmer le mot de passe :</label><br>
        <label>
            <input type="password" name="confirm_password" required>
        </label><br><br>

        <button type="submit">S'inscrire</button>
    </form>

    <p>Déjà un compte ? <a href="index.php?page=login">Connectez-vous</a></p>
</div>
