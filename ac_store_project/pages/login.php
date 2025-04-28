<?php
if (Auth::isConnected()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userDAO = new UserDAO();
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $userDAO->login($email, $password);

    if ($user) {
        Auth::login($user);
        header('Location: index.php');
        exit;
    } else {
        $error = "Identifiants invalides.";
    }
}
?>

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
