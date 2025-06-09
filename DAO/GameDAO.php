<?php

require_once __DIR__ . '/../Models/Game.php';
require_once __DIR__ . '/../Core/Database.php';

class GameDAO
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getGameById(int $id): ?Game
    {
        $stmt = $this->db->prepare("SELECT * FROM games WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Game($data) : null;
    }

    public function getAllGames(): array
    {
        $stmt = $this->db->query("SELECT * FROM games ORDER BY id ASC");
        $games = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $games[] = new Game($row);
        }

        return $games;
    }

    public function getTotalGames(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM games");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['total'];
    }

    public function deleteGame(int $gameId): bool
    {
        $stmt = $this->db->prepare("SELECT delete_game(:id)");
        try {
            return $stmt->execute([':id' => $gameId]);
        } catch (PDOException $e) {
            // Tu peux loguer l'erreur ici
            return false;
        }
    }

    public function addGame(string $title, string $description, float $price, string $image): bool
    {
        $stmt = $this->db->prepare("SELECT add_game(:title, :description, :price, :image)");
        try {
            return $stmt->execute([
                ':title' => $title,
                ':description' => $description,
                ':price' => $price,
                ':image' => $image,
            ]);
        } catch (PDOException $e) {
            // Log de l'erreur possible ici
            return false;
        }
    }
}