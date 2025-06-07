<?php

require_once __DIR__ . '/../Models/Order.php';
require_once __DIR__ . '/../Models/OrderItem.php';
require_once __DIR__ . '/../Core/Database.php';

class OrderDAO
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function createOrder(int $userId, array $cart): int
    {
        try {
            $this->db->beginTransaction();

            // Création de la commande
            $stmt = $this->db->prepare("INSERT INTO orders (user_id) VALUES (:user_id) RETURNING id");
            $stmt->execute([':user_id' => $userId]);
            $orderId = $stmt->fetchColumn();

            // Ajout des éléments dans order_items
            $stmtItem = $this->db->prepare("
                INSERT INTO order_items (order_id, game_id, quantity)
                VALUES (:order_id, :game_id, :quantity)
            ");

            foreach ($cart as $gameId => $quantity) {
                $stmtItem->execute([
                    ':order_id' => $orderId,
                    ':game_id' => $gameId,
                    ':quantity' => $quantity
                ]);
            }

            $this->db->commit();
            return $orderId;

        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Erreur création commande : " . $e->getMessage());
        }
    }

    public function getOrderById(int $orderId): ?Order
    {
        $stmt = $this->db->prepare("
            SELECT o.*, u.username
            FROM orders o
            JOIN users u ON u.id = o.user_id
            WHERE o.id = :id
        ");
        $stmt->execute([':id' => $orderId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Order($data) : null;
    }

    public function getOrderItems(int $orderId): array
    {
        $stmt = $this->db->prepare("
            SELECT g.title, g.price, oi.quantity
            FROM order_items oi
            JOIN games g ON g.id = oi.game_id
            WHERE oi.order_id = :order_id
        ");
        $stmt->execute([':order_id' => $orderId]);

        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new OrderItem($row);
        }
        return $items;
    }

    public function getTotalOrders(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM orders");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['total'];
    }

    public function getAllOrders(): array
    {
        $stmt = $this->db->query("
            SELECT o.id, u.username, o.created_at,
                (SELECT SUM(g.price * oi.quantity)
                 FROM order_items oi
                 JOIN games g ON g.id = oi.game_id
                 WHERE oi.order_id = o.id) AS total
            FROM orders o
            JOIN users u ON u.id = o.user_id
            ORDER BY o.created_at DESC
        ");

        $orders = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $orders[] = new Order($row);
        }
        return $orders;
    }

    public function deleteOrderById(int $orderId): bool
    {
        try {
            $this->db->beginTransaction();

            $stmt1 = $this->db->prepare("DELETE FROM order_items WHERE order_id = :order_id");
            $res1 = $stmt1->execute([':order_id' => $orderId]);

            $stmt2 = $this->db->prepare("DELETE FROM orders WHERE id = :order_id");
            $res2 = $stmt2->execute([':order_id' => $orderId]);

            $this->db->commit();

            return $res1 && $res2;
        } catch (Exception $e) {
            $this->db->rollBack();
            // Tu peux logger $e->getMessage() ici
            return false;
        }
    }
}
