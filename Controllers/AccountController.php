<?php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../DAO/UserDAO.php';
require_once __DIR__ . '/../Core/Auth.php';

class AccountController
{
    private UserDAO $userDAO;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Traitement du formulaire de connexion
    public function login(array $post): void
    {
        $email = trim($post['email'] ?? '');
        $password = $post['password'] ?? '';

        if (!$email || !$password) {
            $error = 'Veuillez remplir tous les champs.';
            require __DIR__ . '/../Views/account/login.php';
            return;
        }

        $user = $this->userDAO->login($email, $password);

        if ($user) {
            Auth::login([
                'id'       => $user->id,
                'username' => $user->username,
                'email'    => $user->email,
                'is_admin' => $user->is_admin,
            ]);
            header('Location: index.php?page=home');
            exit;
        } else {
            $error = 'Identifiants invalides.';
            require __DIR__ . '/../Views/account/login.php';
        }
    }

    // Traitement du formulaire d'inscription
    public function register(array $post): void
    {
        $username = trim($post['username'] ?? '');
        $email = trim($post['email'] ?? '');
        $password = $post['password'] ?? '';
        $passwordConfirm = $post['password_confirm'] ?? '';

        if (!$username || !$email || !$password || !$passwordConfirm) {
            $error = 'Veuillez remplir tous les champs.';
            require __DIR__ . '/../Views/account/register.php';
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Adresse email invalide.';
            require __DIR__ . '/../Views/account/register.php';
            return;
        }

        if ($password !== $passwordConfirm) {
            $error = 'Les mots de passe ne correspondent pas.';
            require __DIR__ . '/../Views/account/register.php';
            return;
        }

        // Optionnel : vérifier si l'email ou username existe déjà (ajouter une méthode dans UserDAO)

        $success = $this->userDAO->register($username, $email, $password);
        if ($success) {
            header('Location: index.php?page=login&registered=1');
            exit;
        } else {
            $error = 'Erreur lors de l\'inscription. Veuillez réessayer.';
            require __DIR__ . '/../Views/account/register.php';
        }
    }

    // Déconnexion
    public function logout(): void
    {
        Auth::logout();
        header('Location: index.php?page=login');
        exit;
    }

    // Retourne l'utilisateur connecté (ou null)
    public function getUser(): ?User
    {
        return Auth::getUser();
    }
}
