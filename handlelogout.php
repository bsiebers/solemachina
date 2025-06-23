<?php
session_start();

// Verwijder alle sessie-variabelen
$_SESSION = [];

// (optioneel) Verwijder de sessiecookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Beëindig de sessie
session_destroy();

// Stuur de gebruiker terug naar de homepage
header("Location: /pages/index.php");
exit;
