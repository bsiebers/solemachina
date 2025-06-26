<?php
session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header('Location: /pages/login.php');
    exit;
}
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/deliverytimeoptions.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/Cart.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/ProductRepository.php';

    
    $deliveryTimes = (new DeliveryTimeOptions())->generate();

    $cartItems = Cart::getItems();
$repo = new ProductRepository();
$productMap = $repo->getByNames(array_keys($cartItems));
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>Winkelwagen</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/winkelwagen.css">
</head>

<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes//header.php'; ?>

<main>
  <div class="checkout-wrapper">
    <h1>Afrekenen</h1>

    <form class="checkout-form" method="post" action="/src/verwerk-bestelling.php">
      <section class="checkout-section">
        <h2>Bestelgegevens</h2>

        <input type="text" name="naam" id="naam" 
          value="<?= isset($_SESSION['user']) 
            ? htmlspecialchars($_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname']) 
            : '' ?>">

        <input type="text" name="adres" id="adres" 
          value="<?= isset($_SESSION['user'])
            ? htmlspecialchars($_SESSION['user']['address']) 
            : '' ?>">

        <input type="text" name="telefoon" placeholder="Telefoonnummer">
        <input type="text" name="opmerking" placeholder="Opmerking">

        <select name="delivery_time" required>
          <option value="">-- Kies een bezorgtijd --</option>
          <?php foreach ($deliveryTimes as $time): ?>
            <option value="<?= htmlspecialchars($time) ?>"><?= htmlspecialchars($time) ?></option>
          <?php endforeach; ?>
        </select>
      </section>

      <section class="checkout-summary">
        <h2>Bestelsamenvatting</h2>
        <div class="summary-box">
          <ul class="bestelling-lijst">
            <?php
              $totaal = 0;
              foreach ($cartItems as $name => $amount):
                $product = $productMap[$name] ?? null;
                if (!$product) continue;
                $subtotaal = $product->price * $amount;
                $totaal += $subtotaal;
            ?>
              <li>
                <span class="product-info">
                  <?= htmlspecialchars($amount) ?>× <?= htmlspecialchars($name) ?>
                </span>
                <span class="product-subtotaal">
                  €<?= number_format($subtotaal, 2, ',', '.') ?>
                </span>
              </li>
            <?php endforeach; ?>
          </ul>

          <p><strong>Totaal: €<?= number_format($totaal, 2, ',', '.') ?></strong></p>

          <?php $isDisabled = Cart::count() === 0; ?>
          <button type="submit" class="btn" <?= $isDisabled ? 'disabled' : '' ?>>
            Bestellen en betalen
          </button>
        </div>
      </section>
    </form>
    
    <section class="remove-items">
      <h2>Producten verwijderen</h2>
      <ul class="verwijder-lijst">
        <?php foreach ($cartItems as $name => $amount): ?>
          <li>
            <form method="post" action="/src/remove-from-cart.php" class="remove-form" onsubmit="return confirm('Verwijder <?= htmlspecialchars($name) ?> uit de winkelwagen?');">
              <input type="hidden" name="product" value="<?= htmlspecialchars($name) ?>">
              <button type="submit" class="btn-small">✕ <?= htmlspecialchars($name) ?></button>
            </form>
          </li>
        <?php endforeach; ?>
      </ul>
    </section>
  </div>
</main>





<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes//footer.html'; ?>

</body>
</html>
