<?php

class Auth
{
    public static function login($user)
    {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'is_admin' => $user['is_admin'],
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

    public static function getUser()
    {
        return $_SESSION['user'] ?? null;
    }
}
