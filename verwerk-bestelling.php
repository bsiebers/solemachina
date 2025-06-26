<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/database/db-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/Cart.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/deliverytimeoptions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/OrderStatus.php';

session_start();

$cartItems = Cart::getItems();
$user = $_SESSION['user'];

if (empty($cartItems) || !$user || !isset($_POST['delivery_time'])) {
    exit('Geen geldige bestelling');
}

$gekozenTijd = $_POST['delivery_time'];
$now = new DateTime('now', new DateTimeZone('Europe/Amsterdam'));

if ($gekozenTijd === 'Zo snel mogelijk') {
    $bezorgtijd = clone $now;
    $bezorgtijd->add(new DateInterval('PT45M'));
} else {
    [$uur, $minuut] = explode(':', $gekozenTijd);
    $bezorgtijd = (clone $now)->setTime((int)$uur, (int)$minuut);
    if ($bezorgtijd < $now) {
        $bezorgtijd->modify('+1 day');
    }
}

$conn = Database::getConnection();
$conn->beginTransaction();

try {
    $result = $conn->query("SELECT MAX(order_id) AS max_id FROM Pizza_Order");
    $maxIdRow = $result->fetch(PDO::FETCH_ASSOC);
    $newOrderId = ($maxIdRow['max_id'] ?? 0) + 1;

    $statusCode = OrderStatus::default();

    $stmt = $conn->prepare("
        INSERT INTO Pizza_Order (order_id, client_username, datetime, status, address)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $newOrderId,
        $user['email'],
        $bezorgtijd->format('Y-m-d H:i:s'),
        $statusCode,
        $user['address']
    ]);

    $stmt = $conn->prepare("
        INSERT INTO Pizza_Order_Product (order_id, product_name, quantity)
        VALUES (?, ?, ?)
    ");
    foreach ($cartItems as $productName => $quantity) {
        $stmt->execute([$newOrderId, $productName, $quantity]);
    }

    $conn->commit();
    Cart::clear();
    header("Location: /pages/bestellingoverzicht.php?order_id=$newOrderId");
    exit;

} catch (Exception $e) {
    $conn->rollBack();
    die("Fout bij bestelling: " . $e->getMessage());
}
