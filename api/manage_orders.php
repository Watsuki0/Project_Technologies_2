<?php
session_start();
require_once __DIR__ . '/../includes/autoload.php';

header('Content-Type: application/json');

if (!Auth::isAdmin()) {
    echo json_encode(['success' => false, 'error' => 'Accès interdit']);
    exit;
}

$orderDAO = new OrderDAO();

$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? null;

switch ($action) {
    case 'delete':
        $orderId = (int) ($input['order_id'] ?? 0);
        if ($orderId > 0) {
            try {
                $orderDAO->deleteOrderById($orderId);
                echo json_encode(['success' => true, 'order_id' => $orderId]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'ID invalide']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Action invalide']);
        break;
}
