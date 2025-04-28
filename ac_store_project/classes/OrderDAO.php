<?php

class OrderDAO
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createOrder($userId, $cart)
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare('INSERT INTO orders (user_id, order_date) VALUES (:user_id, NOW()) RETURNING id');
            $stmt->execute([':user_id' => $userId]);
            $orderId = $stmt->fetchColumn();

            $stmtDetail = $this->db->prepare('INSERT INTO order_details (order_id, game_id, quantity, price) VALUES (:order_id, :game_id, :quantity, :price)');

            foreach ($cart as $gameId => $quantity) {
                $gameDAO = new GameDAO();
                $game = $gameDAO->getGameById($gameId);

                if (!$game) {
                    throw new Exception('Game not found.');
                }

                $stmtDetail->execute([
                    ':order_id' => $orderId,
                    ':game_id' => $gameId,
                    ':quantity' => $quantity,
                    ':price' => $game['price']
                ]);
            }

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getOrdersByUser($userId)
    {
        $stmt = $this->db->prepare('SELECT * FROM orders WHERE user_id = :user_id ORDER BY order_date DESC');
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
