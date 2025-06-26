<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/database/db-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/OrderStatus.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/ProductRepository.php';

if (!isset($_SESSION['user']) || !isset($_GET['order_id'])) {
    header('Location: /pages/menu.php');
    exit;
}

$orderId = (int) $_GET['order_id'];
$conn = Database::getConnection();

$stmt = $conn->prepare("SELECT * FROM Pizza_Order WHERE order_id = ?");
$stmt->execute([$orderId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    exit('Bestelling niet gevonden.');
}

$stmt = $conn->prepare("
    SELECT product_name, quantity 
    FROM Pizza_Order_Product 
    WHERE order_id = ?
");
$stmt->execute([$orderId]);
$productRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$repo = new ProductRepository();
$allProducts = $repo->getAll();
$productMap = [];
foreach ($allProducts as $product) {
    $productMap[$product->name] = $product;
}

$statusText = OrderStatus::getLabel((int) $order['status']);
$statusColor = OrderStatus::getColor((int) $order['status']);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <title>Bestelling Overzicht</title>
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/footer.css">
  <link rel="stylesheet" href="../css/bestellingoverzicht.css">
</head>

<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/html/header.php'; ?>

<main>
  <div class="order-overview-wrapper">

    <section class="order-status">
      <h2>Bestelling status</h2>
      <p><strong>Bestelnummer:</strong> #<?= htmlspecialchars($order['order_id']) ?></p>
      <div class="status-indicator <?= $statusColor ?>"></div>
      <p>Status: <strong><?= htmlspecialchars($statusText) ?></strong></p>
    </section>

    <section class="order-summary">
      <h2>Bestelling</h2>
      <div class="summary-box">
        <ul class="bestelling-lijst">
          <?php
            $totaal = 0;
            foreach ($productRows as $row):
              $product = $productMap[$row['product_name']] ?? null;
              if (!$product) continue;
              $subtotaal = $product->price * $row['quantity'];
              $totaal += $subtotaal;
          ?>
            <li>
              <span class="product-info"><?= htmlspecialchars($row['quantity']) ?>× <?= htmlspecialchars($row['product_name']) ?></span>
              <span class="product-subtotaal">€<?= number_format($subtotaal, 2, ',', '.') ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <p><strong>Totaal: €<?= number_format($totaal, 2, ',', '.') ?></strong></p>
      </div>
    </section>

    <section class="order-support">
      <h2> Hulp nodig?</h2>
      <p>Is er iets mis?<br>Neem contact op</p>
      <a href="#contact" class="btn">Contact opnemen</a>
    </section>

  </div>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/html/footer.html'; ?>

</body>
</html>
