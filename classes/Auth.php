<?php

class Auth
{
    public static function login($user)
    {
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'is_admin' => $user->isAdmin(),
        ];
    }
    public static function logout()
    {
        unset($_SESSION['user']);
        session_unset();
        session_destroy();
    }

    public static function isConnected()
    {
        return isset($_SESSION['user']);
    }

    public static function isAdmin()
    {
        return self::isConnected() && !empty($_SESSION['user']['is_admin']) && $_SESSION['user']['is_admin'] === true;
    }

    public static function getUserId(): ?int
    {
        return $_SESSION['user']['id'] ?? null;
    }

    public static function getUser()
    {
        if (!isset($_SESSION['user'])) {
            throw new Exception("Utilisateur non connecté");
        }
        return $_SESSION['user'];
    }

}
