<?php
session_start();

$error = $_SESSION['error'] ?? '';
$oldEmail = $_SESSION['old_email'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/main-login.css">
    <title>Login</title>
</head>

<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/html/header.php'; ?>

<main>
    <div class="main-content">

        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post" action="/handlelogin.php">
            <label for="email">E-mail:</label>
           <input type="email" id="email" name="email" placeholder="Vul je e-mail in" value="<?= htmlspecialchars($oldEmail) ?>" required>

            <label for="password">Wachtwoord:</label>
            <input type="password" id="password" name="password" placeholder="Vul je wachtwoord in" required>

            <a href="wachtwoord-vergeten.shtml" class="wachtwoord-vergeten">Wachtwoord vergeten</a>
            <button type="submit" class="btn">Inloggen</button>
            <p>of</p>
        </form>

        <a href="register.shtml" class="btn btn-register">Maak een account aan</a>
    </div>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/html/footer.html'; ?>

</body>
</html>
