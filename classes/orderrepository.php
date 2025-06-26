<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/database/db-connection.php';

class OrderRepository {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAllOrders(): array {
        $stmt = $this->conn->query("SELECT * FROM Pizza_Order ORDER BY order_id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductsForOrder(int $orderId): array {
        $stmt = $this->conn->prepare("
            SELECT p.name, pop.quantity, p.price
            FROM Pizza_Order_Product pop
            JOIN Product p ON pop.product_name = p.name
            WHERE pop.order_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById(int $orderId): ?array {
    $stmt = $this->conn->prepare("SELECT * FROM Pizza_Order WHERE order_id = ?");
    $stmt->execute([$orderId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    return $order ?: null;
    }

    public function updateOrderStatus(int $orderId, int $newStatus): bool {
    $stmt = $this->conn->prepare("UPDATE Pizza_Order SET status = ? WHERE order_id = ?");
    return $stmt->execute([$newStatus, $orderId]);
    }

    public function getOrdersByStatus(int $status): array {
    $stmt = $this->conn->prepare("SELECT * FROM Pizza_Order WHERE status = ? ORDER BY order_id DESC");
    $stmt->execute([$status]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateProductQuantity(int $orderId, string $productName, int $quantity): bool {
    $stmt = $this->conn->prepare("
        UPDATE Pizza_Order_Product
        SET quantity = ?
        WHERE order_id = ? AND product_name = ?
    ");
    return $stmt->execute([$quantity, $orderId, $productName]);
    }

    public function removeProductFromOrder(int $orderId, string $productName): bool {
    $stmt = $this->conn->prepare("DELETE FROM Pizza_Order_Product WHERE order_id = ? AND product_name = ?");
    return $stmt->execute([$orderId, $productName]);
}
}
