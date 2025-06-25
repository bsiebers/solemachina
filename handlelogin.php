<?php
session_start();
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

if (empty($email) || empty($password)) {
    echo "E-mailadres en wachtwoord zijn verplicht.";
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM WebUser WHERE username = ?');
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    $_SESSION['error'] = "Geen account gevonden met dit e-mailadres.";
    header('Location: pages/login.php');
    exit;
}

if (!password_verify($password, $user['password'])) {
    $_SESSION['old_email'] = $email; 
    $_SESSION['error'] = "Ongeldig wachtwoord.";
    header('Location: /pages/login.php');
    exit;
}

$_SESSION['user'] = [
    'email' => $user['username'],
    'firstname' => $user['first_name'],
    'lastname' => $user['last_name'],
    'role' => $user['role']
];


if (isset($_SESSION['redirect_after_login'])) {
    $redirect = $_SESSION['redirect_after_login'];
    unset($_SESSION['redirect_after_login']);
    header("Location: $redirect");
    exit;
}

header('Location: /pages/index.php');
exit;

?>
