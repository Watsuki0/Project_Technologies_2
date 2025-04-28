<?php

class UserDAO
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function register($username, $email, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare('INSERT INTO users (username, email, password, is_admin) VALUES (:username, :email, :password, :is_admin)');
        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hash,
            ':is_admin' => 0
        ]);
    }

    public function login($email, $password)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getUserById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
