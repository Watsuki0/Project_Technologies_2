<?php
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../DAO/OrderDAO.php';
require_once __DIR__ . '/../DAO/UserDAO.php';

class AdminController
{
    private OrderDAO $orderDAO;
    private UserDAO $userDAO;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!Auth::isAdmin()) {
            header('Location: ../../index.php');
            exit;
        }

        $this->orderDAO = new OrderDAO();
        $this->userDAO = new UserDAO();
    }

    public function dashboard(): array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['delete_user'])) {
                $userId = (int)($_POST['user_id'] ?? 0);
                if ($userId > 0) {
                    $this->userDAO->deleteUser($userId);
                }
                header('Location: ?page=dashboard');
                exit;
            }

            if (isset($_POST['delete_order'])) {
                $orderId = (int)($_POST['order_id'] ?? 0);
                if ($orderId > 0) {
                    $this->orderDAO->deleteOrderById($orderId);
                }
                header('Location: ?page=dashboard');
                exit;
            }
        }

        $users = $this->userDAO->getAllUsers();
        $orders = $this->orderDAO->getAllOrders();

        return ['users' => $users, 'orders' => $orders];
    }
}
