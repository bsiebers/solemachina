<?php
session_start();
require_once '../classes/ProductRepository.php';

$repo = new ProductRepository();
$products = $repo->getAll();

$groupedByType = [];
foreach ($products as $product) {
    $groupedByType[$product->type][] = $product;
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/menu.css">
    <title>Menu</title>
</head>

<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/html/header.php'; ?>

<main>
  <div class="menu-wrapper">
    <?php foreach ($groupedByType as $type => $items): ?>
      <section class="menu-category">
        <h2><?= htmlspecialchars($type) ?></h2>
        <div class="product-grid">
        <?php foreach ($items as $product): ?>
          <div class="product-card">
            <img src="/public/images/<?= strtolower(str_replace(' ', '-', $product->name)) ?>.jpg" alt="<?= htmlspecialchars($product->name) ?>">
            <div class="product-info">
              <h3><?= htmlspecialchars($product->name) ?></h3>
              <div class="product-details">
             <span class="product-ingredients"><?= htmlspecialchars(implode(', ', $product->ingredients)) ?></span>
            <span class="product-price">€<?= number_format($product->price, 2, ',', '.') ?></span>
            </div>
              <form method="POST" action="/add-to-cart.php" class="add-to-cart-form">
                <input type="hidden" name="product" value="<?= htmlspecialchars($product->name) ?>">
                <input type="hidden" name="price" value="<?= htmlspecialchars($product->price) ?>">
                <button type="submit" class="btn">Toevoegen</button>
                </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endforeach; ?>
  </div>
</main>



<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/html/footer.html'; ?>
