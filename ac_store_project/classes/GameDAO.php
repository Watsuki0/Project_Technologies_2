<?php
class GameDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAllGames() {
        $stmt = $this->db->prepare("SELECT * FROM games ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getGameById($id) {
        $stmt = $this->db->prepare("SELECT * FROM games WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function addGame($title, $description, $price, $image) {
        $stmt = $this->db->prepare("SELECT add_game(:title, :description, :price, :image)");
        return $stmt->execute([
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'image' => $image
        ]);
    }

    public function deleteGame($id) {
        $stmt = $this->db->prepare("SELECT delete_game(:id)");
        return $stmt->execute(['id' => $id]);
    }
}
?>
