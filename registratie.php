<?php
$pdo = new PDO('mysql:host=localhost;dbname=testdb');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Ongeldige verzoekmethode";
    exit;
}

$username = trim($_POST['username']);
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    echo "Gebruikersnaam en wachtwoord zijn verplicht.";
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user) {
    echo "Gebruikersnaam bestaat al";
} else {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
    if ($stmt->execute([$username, $hash])) {
        echo "Gebruiker succesvol geregistreerd";
    } else {
        echo "Er is een fout opgetreden bij het registreren van de gebruiker";
    }
}
?>
