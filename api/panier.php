<?php
session_start();
require_once __DIR__ . '/../includes/autoload.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true) ?? [];
$action = $input['action'] ?? ($_POST['action'] ?? null);

$gameDAO = new GameDAO();
$orderDAO = new OrderDAO();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

switch ($action) {
    case 'update':
        $gameId = (int)($input['game_id'] ?? $_POST['game_id'] ?? 0);
        $quantity = (int)($input['quantity'] ?? $_POST['quantity'] ?? 0);

        if ($quantity > 0) {
            $_SESSION['cart'][$gameId] = $quantity;
        }

        $game = $gameDAO->getGameById($gameId);
        $subtotal = $game ? $game->price * $quantity : 0;
        $total = 0;
        foreach ($_SESSION['cart'] as $gid => $qty) {
            $g = $gameDAO->getGameById($gid);
            if ($g) $total += $g->price * $qty;
        }

        echo json_encode([
            'success' => true,
            'subtotal' => $subtotal,
            'total' => $total
        ]);
        break;

    case 'clear':
        $_SESSION['cart'] = [];
        echo json_encode(['success' => true]);
        break;

    case 'checkout':
        $userId = Auth::getUser()['id'] ?? null;
        if (!$userId) {
            echo json_encode(['success' => false, 'error' => 'Utilisateur non connecté.']);
            exit;
        }
        if (!empty($_SESSION['cart'])) {
            $orderId = $orderDAO->createOrder($userId, $_SESSION['cart']);
            $_SESSION['cart'] = [];
            echo json_encode(['success' => true, 'order_id' => $orderId]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Panier vide.']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Action invalide']);
}
