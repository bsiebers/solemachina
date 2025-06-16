<?php
$pdo = new PDO('mysql:host=localhost;dbname=testdb');

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
$stmt->execute([$username]);

$user = $stmt->fetch();
if($user && password_verify($password , $user['password'])) {
    echo "Ingelogd!";
}else {
    echo "Foutieve gebruikersnaam of wachtwoord.";
}
?>
