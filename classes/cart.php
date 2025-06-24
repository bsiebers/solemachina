<?php
class Cart {
    public static function add($productName) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $_SESSION['cart'][$productName] = ($_SESSION['cart'][$productName] ?? 0) + 1;
    }

    public static function count() {
        return isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
    }

    public static function getItems() {
        return $_SESSION['cart'] ?? [];
    }

    public static function clear() {
        unset($_SESSION['cart']);
    }
}