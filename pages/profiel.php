<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: /pages/login.php');
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/OrderRepository.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/OrderStatus.php';

$repo = new OrderRepository();
$email = $_SESSION['user']['email'];
$orders = $repo->getOrdersByEmail($email);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Mijn Bestellingen</title>
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/bestellingen.css">
</head>
<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/html/header.php'; ?>

<main>
  <div class="order-list-wrapper">
    <h1>Mijn Bestellingen</h1>

    <div class="order-cards">
      <?php foreach ($orders as $order): 
        $status = (int) $order['status'];
        $statusClass = OrderStatus::getColor($status);
        $statusLabel = OrderStatus::getLabel($status);
        $producten = $repo->getProductsForOrder($order['order_id']);
      ?>
        <div class="order-card">
          <div class="order-content">
            <div class="order-details">
              <p><strong>Bestelling #<?= htmlspecialchars($order['order_id']) ?></strong></p>
              <p>Status: <?= htmlspecialchars($statusLabel) ?></p>

              <ul class="bestelling-lijst">
                <?php foreach ($producten as $item): ?>
                  <li>
                    <span class="product-info">
                      <?= htmlspecialchars($item['quantity']) ?>× <?= htmlspecialchars($item['name']) ?>
                    </span>
                    <span class="product-subtotaal">
                      €<?= number_format($item['price'] * $item['quantity'], 2, ',', '.') ?>
                    </span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
            <span class="status-indicator <?= htmlspecialchars($statusClass) ?>" title="<?= htmlspecialchars($statusLabel) ?>"></span>
          </div>
        </div>
      <?php endforeach; ?>
          </div>
  </div>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/html/footer.html'; ?>
</body>
</html>
