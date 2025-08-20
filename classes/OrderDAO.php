<?php

class OrderDAO
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }
    // Ajout d'une commande via la fonction PL/pgSQL add_order (retourne un int)
    public function createOrder($userId, $cart)
    {
        try {
            $this->db->beginTransaction();

            // Création de la commande et récupération de l'ID
            $stmt = $this->db->prepare("SELECT add_order(:user_id)");
            $stmt->execute([':user_id' => $userId]);
            $orderId = (int) $stmt->fetchColumn(); // assure un int côté PHP

            // Ajout des items de la commande
            $stmtDetail = $this->db->prepare("
            CALL add_order_item(:order_id, :game_id, :quantity)
        ");
            foreach ($cart as $gameId => $quantity) {
                $stmtDetail->execute([
                    ':order_id' => $orderId,
                    ':game_id'  => $gameId,
                    ':quantity' => $quantity
                ]);
            }

            $this->db->commit();
            return $orderId;

        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Erreur lors de la création de la commande : " . $e->getMessage());
        }
    }


    public function deleteOrderById($orderId)
    {
        $stmt = $this->db->prepare("CALL delete_order(:id)");
        $stmt->execute([':id' => $orderId]);
    }

    public function getOrderById($orderId): ?Order
    {
        $stmt = $this->db->prepare("
            SELECT o.*, u.username
            FROM orders o
            JOIN users u ON u.id = o.user_id
            WHERE o.id = :id
        ");
        $stmt->execute([':id' => $orderId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Order(
            $data['id'],
            $data['user_id'],
            $data['username'],
            $data['created_at']
        );
    }

    public function getOrderItems($orderId): array
    {
        $stmt = $this->db->prepare("
            SELECT g.title, g.price, oi.quantity
            FROM order_items oi
            JOIN games g ON g.id = oi.game_id
            WHERE oi.order_id = :order_id
        ");
        $stmt->execute([':order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            SELECT o.id, o.user_id, u.username, o.created_at, 
                   (SELECT SUM(g.price * oi.quantity)
                    FROM order_items oi
                    JOIN games g ON oi.game_id = g.id
                    WHERE oi.order_id = o.id) AS total
            FROM orders o
            JOIN users u ON o.user_id = u.id
        ");

        $orders = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $orders[] = new Order(
                $data['id'],
                $data['user_id'],
                $data['username'],
                $data['created_at'],
                $data['total'] ?? 0
            );
        }

        return $orders;
    }
}

