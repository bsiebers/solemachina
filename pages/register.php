<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="../css/base.css">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/footer.css">
        <link rel="stylesheet" href="../css/main-login.css">
        <title>Account maken</title>
    </head>

    <body>
  
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes//header.php'; ?>

        <main>
            <div class="main-content">
            <form method="post" action="/src/handleregister.php">
                <h1>Account maken</h1>
                <input type="email" name="email" placeholder="E-mailadres" required>
                <input type="password" name="password" placeholder="Wachtwoord" required>
                <input type="password" name="confirm_password" placeholder="Bevestig wachtwoord" required>
                <div class="smallbox">
                    <input type="text" name="firstname" placeholder="Voornaam" required>
                    <input type="text" name="lastname" placeholder="Achternaam" required>
                    <input type="text" name="adress" placeholder="Adres" required>
                    <input type="text" name="postalcode" placeholder="Postcode" required>
                </div>
                <input type="number" name="phonenumber" placeholder="Telefoonnummer" required>
                <div class="voorwaarden-check">
                <a href="privacy-policy.shtml" target="_blank" class="privacy-policy">Ik ga akkoord met de voorwaarden en het privacy beleid.</a>
                <input type="checkbox" name="terms" id="terms" required>
                </div>
                <button type="submit" class="btn">Account aanmaken</button>
            </form>
            </div>
        </main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes//footer.html'; ?>

    </body>
</html>