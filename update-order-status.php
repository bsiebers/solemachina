<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'medewerker') {
    http_response_code(403);
    echo "Geen toegang";
    exit;
}

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo "Geen order ID meegegeven";
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/OrderRepository.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/OrderStatus.php';

$orderId = (int) $_GET['id'];

$repo = new OrderRepository();
$order = $repo->getOrderById($orderId);

if (!$order) {
    http_response_code(404);
    echo "Bestelling niet gevonden";
    exit;
}

$currentStatus = (int) $order['status'];
$newStatus = $currentStatus + 1;

if ($newStatus > 3) {
    $newStatus = 3;
}

$success = $repo->updateOrderStatus($orderId, $newStatus);

if ($success) {
    header("Location: /pages/bestellingen.php");
    exit;
} else {
    http_response_code(500);
    echo "Bijwerken mislukt";
}
