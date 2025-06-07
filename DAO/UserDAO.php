<?php

require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/User.php';

class UserDAO
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function register(string $username, string $email, string $password): bool
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare('
        INSERT INTO users (username, email, password, is_admin) 
        VALUES (:username, :email, :password, :is_admin)
    ');
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $hash);
        $stmt->bindValue(':is_admin', false, PDO::PARAM_BOOL);  // Ici on précise que c’est un booléen
        return $stmt->execute();
    }



    public function login(string $email, string $password): ?User
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data && password_verify($password, $data['password'])) {
            // On retourne un objet User sans le mot de passe
            unset($data['password']);
            return new User($data);
        }
        return null;
    }

    public function getUserById(int $id): ?User
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new User($data) : null;
    }

    public function getAllUsers(): array
    {
        $stmt = $this->db->query('SELECT * FROM users');
        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            unset($row['password']);
            $users[] = new User($row);
        }
        return $users;
    }

    public function getTotalUsers(): int
    {
        $stmt = $this->db->query('SELECT COUNT(*) AS total FROM users');
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['total'];
    }

    public function deleteUser(int $userId): bool
    {
        try {
            $stmt = $this->db->prepare('DELETE FROM users WHERE id = :id');
            return $stmt->execute([':id' => $userId]);
        } catch (PDOException $e) {
            // Logger l'erreur ici si besoin
            return false;
        }
    }
}