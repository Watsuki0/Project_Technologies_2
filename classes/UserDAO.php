<?php

class UserDAO
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
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
        $stmt = $this->db->prepare('SELECT id, username, email, password, is_admin FROM users WHERE email = :email');
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
    public function getTotalUsers()
    {
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM users");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function deleteUser($userId)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $userId]);
    }

    public function getAllUsers()
    {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
