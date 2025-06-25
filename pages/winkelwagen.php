<?php
session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header('Location: /pages/login.php');
    exit;
}
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

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/html/header.php'; ?>

<main>
  <div class="checkout-wrapper">
    <h1>Afrekenen</h1>

    <section class="checkout-section">
      <h2>Bestelgegevens</h2>
      <form class="checkout-form">
        <input type="text" placeholder="Naam">
        <input type="text" placeholder="Adresgegevens">
        <input type="text" placeholder="Telefoonnummer">
        <input type="text" placeholder="Opmerking">
        <input type="text" placeholder="Bezorgtijd">
      </form>
    </section>

    <section class="checkout-summary">
      <h2>Bestelsamenvatting</h2>
      <div class="summary-box">
        <p>Bestelling</p>
        <button class="btn">Bestel en betaal</button>
      </div>
    </section>
  </div>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/html/footer.html'; ?>

</body>
</html>
