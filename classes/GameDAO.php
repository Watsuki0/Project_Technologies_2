<?php

class GameDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Fonction pour récupérer un jeu par son ID
    public function getGameById($id): Game {
        $stmt = $this->db->prepare("SELECT * FROM games WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Game($row['id'], $row['title'], $row['description'], $row['price'], $row['image']);
    }

    // Suppression des jeux via la fonction PL/pgSQL delete_game
    public function deleteGame($gameId){
        $stmt = $this->db->prepare("SELECT delete_game(:id)");
        $stmt->execute([':id' => $gameId]);
    }

    // Ajout de jeux via la fonction PL/pgSQL add_game
    public function addGame(Game $game){
        $stmt = $this->db->prepare("SELECT add_game(:title, :description, :price, :image)");
        $stmt->execute([
            ':title' => $game->title,
            ':description' => $game->description,
            ':price' => $game->price,
            ':image' => $game->image,
        ]);
    }

    // Récupération de tous les jeux existants
    public function getAllGames(): array {
        $stmt = $this->db->query("SELECT * FROM games ORDER BY id ASC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $games = [];
        foreach ($rows as $row) {
            $games[] = new Game($row['id'], $row['title'], $row['description'], $row['price'], $row['image']);
        }

        return $games;
    }

    // Récupération du nombre total de jeux dans la base
    public function getTotalGames(): int {
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM games");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['total'];
    }
}

