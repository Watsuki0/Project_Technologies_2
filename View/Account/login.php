<?php
require_once __DIR__ . '/../../Core/Auth.php';
require_once __DIR__ . '/../../DAO/UserDAO.php';

if (Auth::isConnected()) {
    header('Location: cart.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userDAO = new UserDAO();
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = $userDAO->login($email, $password);

    if ($user) {
        Auth::login([
            'id'       => $user->id,
            'username' => $user->username,
            'email'    => $user->email,
            'is_admin' => $user->is_admin,
        ]);
        header('Location: index.php');
        exit;
    } else {
        $error = "Identifiants invalides.";
    }
}
?>
<div class="auth-container">
    <h1>Connexion</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Email :</label><br>
        <input type="email" name="email" required><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Se connecter</button>
    </form>

    <p>Pas encore inscrit ? <a href="index.php?page=register">Créer un compte</a></p>
</div>
