<?php

class UserDAO
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function register(User $user, string $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare('
        INSERT INTO users (username, email, password, is_admin)
        VALUES (:username, :email, :password, :is_admin)
    ');

        return $stmt->execute([
            ':username' => $user->getUsername(),
            ':email' => $user->getEmail(),
            ':password' => $hash,
            ':is_admin' => $user->isAdmin() ? 1 : 0
        ]);
    }


    public function login(string $email, string $password): ?User
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data && password_verify($password, $data['password'])) {
            return $this->hydrate($data);
        }
        return null;
    }

    public function getAllUsers(): array
    {
        $stmt = $this->db->query('SELECT * FROM users');
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'hydrate'], $data);
    }

    public function getTotalUsers(): int
    {
        $stmt = $this->db->query('SELECT COUNT(*) AS total FROM users');
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['total'];
    }

    public function deleteUser(int $userId): void
    {
        $stmt = $this->db->prepare('DELETE FROM users WHERE id = :id');
        $stmt->execute([':id' => $userId]);
    }

    //Permet de fournir des données correspondantes aux attributs : Aide : Easy-micro.org.
    private function hydrate(array $data): User
    {
        return new User(
            (int) $data['id'],
            $data['username'],
            $data['email'],
            $data['password'],
            (bool) $data['is_admin']
        );
    }
}

