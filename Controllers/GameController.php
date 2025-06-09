<?php

require_once __DIR__ . '/../DAO/GameDAO.php';

class GameController
{
    private GameDAO $gameDAO;

    public function __construct()
    {
        $this->gameDAO = new GameDAO();
    }

    // Récupérer un jeu par son id
    public function show(int $id): ?Game
    {
        return $this->gameDAO->getGameById($id);
    }

    // Récupérer tous les jeux
    public function index(): array
    {
        return $this->gameDAO->getAllGames();
    }

    public function create(string $title, string $description, float $price, string $image): void
    {
        $this->gameDAO->addGame($title, $description, $price, $image);
    }

    // Supprimer un jeu par son id
    public function delete(int $gameId): void
    {
        $this->gameDAO->deleteGame($gameId);
    }

    // Optionnel : méthode pour compter total jeux
    public function count(): int
    {
        return $this->gameDAO->getTotalGames();
    }
}
