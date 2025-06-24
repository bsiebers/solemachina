<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/Cart.php';
$cartCount = Cart::count();
?>

<header>
  <div class="navbar">
    <div class="logo">
      <a href="/pages/index.php">
        <img class="logo-img" src="/public/images/logo.png" alt="Pizzeria Sole Machina Logo">
      </a>
    </div>

    <nav class="nav-links">
      <a href="/pages/menu.php">Menu</a>
      <a href="#contact">Contact</a>
      <a href="#over-ons">Over ons</a>

      <?php if (isset($_SESSION['user'])): ?>
        <div class="login-link">
          <img src="/public/images/account.png" alt="Account icoon" class="login-icon">
          <span><?= htmlspecialchars($_SESSION['user']['firstname']) ?></span>
        </div>
      <?php else: ?>
        <a href="/pages/login.php" class="login-link">
          <img src="/public/images/account.png" alt="Login icoon" class="login-icon">
          <span>Login</span>
        </a>
      <?php endif; ?>

      <div class="cart-link">
        <a href="/pages/winkelwagen.php">
          <img src="/public/images/shoppingcart.png" alt="Winkelwagen" class="cart-icon">
          <?php if ($cartCount > 0): ?>
            <span class="cart-count"><?= $cartCount ?></span>
          <?php endif; ?>
        </a>

        <?php if ($cartCount > 0): ?>
          <div class="mini-cart">
            <ul>
              <?php foreach (Cart::getItems() as $name => $amount): ?>
                <li>
                  <?= htmlspecialchars($name) ?> (<?= $amount ?>)
                  <form method="post" action="/remove-from-cart.php" class="remove-form">
                    <input type="hidden" name="product" value="<?= htmlspecialchars($name) ?>">
                    <button type="submit">✕</button>
                  </form>
                </li>
              <?php endforeach; ?>
            </ul>
            <a href="/pages/winkelwagen.php" class="mini-cart-button">Bekijk winkelwagen</a>
          </div>
        <?php endif; ?>
      </div>

      <?php if (isset($_SESSION['user'])): ?>
        <a href="/handlelogout.php" class="login-link">Uitloggen</a>
      <?php endif; ?>
    </nav>
  </div>

  <div class="subbar">
    <a href="/pages/menu.php" class="button">Bestellen</a>
  </div>
</header>
