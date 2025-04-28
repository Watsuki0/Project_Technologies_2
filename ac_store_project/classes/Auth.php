<?php

class Auth
{
    public static function login($user)
    {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
    }

    public static function logout()
    {
        unset($_SESSION['user']);
    }

    public static function isConnected()
    {
        return isset($_SESSION['user']);
    }

    public static function isAdmin()
    {
        return self::isConnected() && $_SESSION['user']['role'] === 'admin';
    }

    public static function getUser()
    {
        return $_SESSION['user'] ?? null;
    }
}
