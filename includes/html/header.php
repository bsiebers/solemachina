<?php
echo '<pre style="background: white; color: black; padding: 10px;">';
var_dump($_SESSION);
echo '</pre>';
?>

<header>
  <div class="navbar">
    <div class="logo">
      <a href="/pages/index.php">
        <img class="logo-img" src="/public/images/logo.png" alt="Pizzeria Sole Machina Logo">
      </a>
    </div>
    <nav class="nav-links">
      <a href="/menu.shtml">Menu</a>
      <a href="#contact">Contact</a>
      <a href="#over-ons">Over ons</a>

      <?php if (isset($_SESSION['user'])): ?>
        <!-- Ingelogde weergave -->
        <div class="login-link">
          <img src="/public/images/account.png" alt="Account icoon" class="login-icon">
          <span><?= htmlspecialchars($_SESSION['user']['firstname']) ?></span>
        </div>
        <a href="/handlelogout.php" class="login-link">Uitloggen</a>
      <?php else: ?>
        <!-- Niet ingelogd -->
        <a href="/pages/login.php" class="login-link">
          <img src="/public/images/account.png" alt="Login icoon" class="login-icon">
          <span>Login</span>
        </a>
      <?php endif; ?>
    </nav>
  </div>
  <div class="subbar">
    <a href="/menu.shtml" class="button">Bestellen</a>
  </div>
</header>
