<?php
session_start();
require_once __DIR__ . '/classes/Cart.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product'])) {
    $product = $_POST['product'];

    if (isset($_SESSION['cart'][$product])) {
        unset($_SESSION['cart'][$product]);
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
