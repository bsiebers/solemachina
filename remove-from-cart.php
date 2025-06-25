<?php
session_start();
require_once 'classes/Cart.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product'])) {
    $product = $_POST['product'];
    Cart::remove($product);
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
