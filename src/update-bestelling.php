<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'medewerker') {
    header('Location: /pages/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pages/bestellingen.php');
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/OrderRepository.php';

$repo = new OrderRepository();

$orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
$status = isset($_POST['status']) ? (int)$_POST['status'] : null;
$aantallen = $_POST['aantallen'] ?? [];

if (!$orderId || $status === null) {
    die('Ongeldige invoer.');
}

$repo->updateOrderStatus($orderId, $status);

foreach ($aantallen as $productName => $quantity) {
    $productName = trim($productName);
    $quantity = max(0, (int)$quantity);

    if ($quantity > 0) {
        $repo->updateProductQuantity($orderId, $productName, $quantity);
    }
}


header("Location: /pages/bestellingen.php");
exit;
