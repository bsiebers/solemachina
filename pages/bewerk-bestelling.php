<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'medewerker') {
    header('Location: /pages/index.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Ongeldig order ID');
}

$orderId = (int) $_GET['id'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/OrderRepository.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/OrderStatus.php';

$repo = new OrderRepository();
$order = $repo->getOrderById($orderId);
$producten = $repo->getProductsForOrder($orderId);

if (!$order) {
    die("Bestelling niet gevonden.");
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bestelling Bewerken - Pizzeria Sole Machina</title>
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/bewerk-bestelling.css">
</head>
<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes//header.php'; ?>

<main>
  <div class="order-edit-wrapper">
    <h1>Bestelling #<?= htmlspecialchars($order['order_id']) ?> bewerken</h1>

    <form method="post" action="/src/update-bestelling.php">
      <input type="hidden" name="order_id" value="<?= $orderId ?>">

      <label for="status">Status:</label>
      <select name="status" id="status">
        <?php foreach (OrderStatus::$map as $code => $data): ?>
          <option value="<?= $code ?>" <?= $order['status'] == $code ? 'selected' : '' ?>>
            <?= htmlspecialchars($data['label']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <h2>Producten</h2>
      <ul class="producten-lijst">
        <?php foreach ($producten as $item): ?>
          <li class="product-row">
            <span>
              <?= htmlspecialchars($item['name']) ?> - €<?= number_format($item['price'], 2, ',', '.') ?>
            </span>
            <input type="number" name="aantallen[<?= htmlspecialchars($item['name']) ?>]" value="<?= $item['quantity'] ?>" min="0">
          </li>
        <?php endforeach; ?>
      </ul>

      <button type="submit" class="btn">Bestelling bijwerken</button>
    </form>

    <h2>Verwijder producten</h2>
    <ul class="verwijder-lijst">
      <?php foreach ($producten as $item): ?>
        <li>
          <form method="post" action="/src/verwijder-product-uit-bestelling.php" onsubmit="return confirm('Verwijder dit product uit de bestelling?');" style="display:inline;">
            <input type="hidden" name="order_id" value="<?= $orderId ?>">
            <input type="hidden" name="product_name" value="<?= htmlspecialchars($item['name']) ?>">
            <button type="submit" class="btn-small">✕ <?= htmlspecialchars($item['name']) ?></button>
          </form>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</main>



<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes//footer.html'; ?>

</body>
</html>
