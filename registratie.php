<?php
require_once 'database/db-connection.php'; 

$db = new Database();
$pdo = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Ongeldige verzoekmethode";
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';
$firstname = trim($_POST['firstname'] ?? '');
$lastname = trim($_POST['lastname'] ?? '');
$address = trim($_POST['adress'] ?? '');
$postalcode = trim($_POST['postalcode'] ?? '');
$phonenumber = trim($_POST['phonenumber'] ?? '');

if ($password !== $confirm) {
    echo "Wachtwoorden komen niet overeen.";
    exit;
}

$stmt = $pdo->prepare('SELECT 1 FROM WebUser WHERE username = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    echo "Er bestaat al een account met dit e-mailadres.";
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare('INSERT INTO WebUser (username, password, first_name, last_name, role, address) VALUES (?, ?, ?, ?, ?, ?)');
if ($stmt->execute([$email, $hash, $firstname, $lastname,'klant', $address])) {
    $_SESSION['user'] = [
        'email' => $email,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'role' => 'klant'
    ];
    
    header('Location: pages/index.shtml');
    exit;

} else {
    echo "Er is een fout opgetreden bij het registreren van de gebruiker";
}
?>
