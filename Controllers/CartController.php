<?php

require_once __DIR__ . '/../Models/Game.php';
require_once __DIR__ . '/../DAO/GameDAO.php';

class CartController
{
    private GameDAO $gameDAO;

    public function __construct()
    {
        $this->gameDAO = new GameDAO();

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // Gestion des actions POST
    public function handleRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? null;

            switch ($action) {
                case 'add_to_cart':
                    $gameId = (int)($_POST['game_id'] ?? 0);
                    $quantity = max(1, (int)($_POST['quantity'] ?? 1));
                    if ($gameId > 0) {
                        $this->addToCart($gameId, $quantity);
                        header('Location: cart.php?page=cart');
                        exit;
                    }
                    break;

                case 'remove_from_cart':
                    $gameId = (int)($_POST['game_id'] ?? 0);
                    if ($gameId > 0) {
                        $this->removeFromCart($gameId);
                        header('Location: cart.php?page=cart');
                        exit;
                    }
                    break;

                case 'clear_cart':
                    $this->clearCart();
                    header('Location: cart.php?page=cart');
                    exit;
                    break;

                case 'update_quantities':
                    $quantities = $_POST['quantities'] ?? [];
                    if (is_array($quantities)) {
                        $this->updateQuantities($quantities);
                        header('Location: cart.php?page=cart');
                        exit;
                    }
                    break;

                default:
                    // Action inconnue ou absente => ne rien faire
                    break;
            }
        }
    }

    public function addToCart(int $gameId, int $quantity = 1): void
    {
        if ($quantity < 1) {
            $quantity = 1;
        }

        if (isset($_SESSION['cart'][$gameId])) {
            $_SESSION['cart'][$gameId] += $quantity;
        } else {
            $_SESSION['cart'][$gameId] = $quantity;
        }
    }

    public function removeFromCart(int $gameId): void
    {
        if (isset($_SESSION['cart'][$gameId])) {
            unset($_SESSION['cart'][$gameId]);
        }
    }

    public function clearCart(): void
    {
        $_SESSION['cart'] = [];
    }

    public function updateQuantities(array $quantities): void
    {
        foreach ($quantities as $gameId => $qty) {
            $qty = (int)$qty;
            if ($qty <= 0) {
                unset($_SESSION['cart'][$gameId]);
            } else {
                $_SESSION['cart'][$gameId] = $qty;
            }
        }
    }

    public function getCartItems(): array
    {
        $items = [];
        foreach ($_SESSION['cart'] as $gameId => $quantity) {
            $game = $this->gameDAO->getGameById($gameId);
            if ($game) {
                $items[] = [
                    'game' => $game,
                    'quantity' => $quantity,
                    'total_price' => $game->price * $quantity,
                ];
            }
        }
        return $items;
    }

    public function getTotal(): float
    {
        $total = 0.0;
        foreach ($_SESSION['cart'] as $gameId => $quantity) {
            $game = $this->gameDAO->getGameById($gameId);
            if ($game) {
                $total += $game->price * $quantity;
            }
        }
        return $total;
    }
}
