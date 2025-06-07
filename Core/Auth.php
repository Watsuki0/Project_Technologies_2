<?php
require_once __DIR__ . '/../Models/User.php';  // adapte le chemin selon ta structure
class Auth
{
    public static function login(array $user): void
    {
        $_SESSION['user'] = [
            'id'       => $user['id'],
            'username' => $user['username'],
            'email'    => $user['email'],
            'is_admin' => (bool)$user['is_admin'],
        ];
    }

    public static function logout(): void
    {
        unset($_SESSION['user']);
    }

    public static function isConnected(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function isAdmin(): bool
    {
        return self::isConnected() && !empty($_SESSION['user']['is_admin']);
    }

    public static function getUser(): ?User
    {
        if (!self::isConnected()) {
            return null;
        }

        $data = $_SESSION['user'];
        return new User($data);  // <-- un seul argument tableau
    }

}
