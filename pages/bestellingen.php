<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'medewerker') {
    header('Location: /pages/index.php');
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/OrderRepository.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/OrderStatus.php';

$repo = new OrderRepository();
$statusFilter = isset($_GET['status']) ? (int) $_GET['status'] : null;
$orders = $statusFilter ? $repo->getOrdersByStatus($statusFilter) : $repo->getAllOrders();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bestellingen - Pizzeria Sole Machina</title>
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
    <h1>Bestellingen</h1>

    <form method="get" class="status-filter-form">
      <label for="filter">Filter op status:</label>
      <select name="status" id="filter" onchange="this.form.submit()">
        <option value="">Alle</option>
        <option value="1" <?= ($_GET['status'] ?? '') === '1' ? 'selected' : '' ?>>Bezig met bereiden</option>
        <option value="2" <?= ($_GET['status'] ?? '') === '2' ? 'selected' : '' ?>>Onderweg</option>
        <option value="3" <?= ($_GET['status'] ?? '') === '3' ? 'selected' : '' ?>>Geleverd</option>
      </select>
    </form>

    <section class="order-cards">
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

              <div class="order-actions">
                <?php if ($status < 3): ?>
                  <form method="get" action="/update-order-status.php" class="status-update-form">
                    <input type="hidden" name="id" value="<?= $order['order_id'] ?>">
                    <button type="submit" class="status-update-button" title="Volgende status">
                      ➜
                    </button>
                  </form>
                <?php endif; ?>

                <a href="/pages/bewerk-bestelling.php?id=<?= $order['order_id'] ?>" class="view-order-button">
                  Bekijk
                </a>
              </div>
            </div>

            <span class="status-indicator <?= htmlspecialchars($statusClass) ?>" title="<?= htmlspecialchars($statusLabel) ?>"></span>
          </div>
        </div>
      <?php endforeach; ?>
    </section>
  </div>
</main>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/html/footer.html'; ?>

</body>
</html>
