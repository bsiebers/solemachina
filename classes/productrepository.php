<?php
require_once '../database/db-connection.php';
require_once '../classes/product.php';

class ProductRepository {
    public function getAll() {
        $conn = Database::getConnection();
        $sql = "
        SELECT
            p.name AS product_name,
            p.price,
            pt.name AS type,
            i.name AS ingredient
        FROM Product p
        JOIN ProductType pt ON p.type_id = pt.name
        LEFT JOIN Product_Ingredient pi ON p.name = pi.product_name
        LEFT JOIN Ingredient i on pi.ingredient_name = i.name
        ORDER BY pt.name, p.name;
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $grouped = [];
        foreach ($rows as $row) {
            $name = $row['product_name'];
            if (!isset($grouped[$name])) {
                $grouped[$name] = new Product($name, $row['price'], $row['type']);
            }
            if ($row['ingredient']) {
                $grouped[$name]->ingredients[] = $row['ingredient'];
            }

        }
        return array_values($grouped);
    }
}