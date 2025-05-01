<?php
class GameDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Fonction pour récupérer un jeu par son ID
    public function getGameById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM games WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Suppression des jeux via la fonction PL/pgSQL delete_game
    public function deleteGame($gameId)
    {
        $stmt = $this->db->prepare("SELECT delete_game(:id)");
        $stmt->execute([':id' => $gameId]);
    }

    // Ajout de jeux via la fonction PL/pgSQL add_game
    public function addGame($title, $description, $price, $image)
    {
        $stmt = $this->db->prepare("SELECT add_game(:title, :description, :price, :image)");
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':price' => $price,
            ':image' => $image,
        ]);
    }

    // Récupération de tous les jeux existants
    public function getAllGames()
    {
        $stmt = $this->db->query("SELECT * FROM games ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupération du nombre total de jeux dans la base
    public function getTotalGames()
    {
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM games");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
?>