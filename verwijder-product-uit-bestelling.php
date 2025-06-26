<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'medewerker') {
    header('Location: /pages/index.php');
    exit;
}

if (!isset($_POST['order_id'], $_POST['product_name'])) {
    die('Ontbrekende gegevens');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/OrderRepository.php';

$repo = new OrderRepository();
$success = $repo->removeProductFromOrder((int)$_POST['order_id'], $_POST['product_name']);

header('Location: /pages/bewerk-bestelling.php?id=' . (int)$_POST['order_id']);
exit;
