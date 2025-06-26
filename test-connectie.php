<?php
try {
    $serverName = "host.docker.internal";
    $database = "Pizzadatabase";
    $username = "pizzaadmin";
    $password = "admin";

    $dsn = "sqlsrv:server=$serverName;Database=$database";

    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Verbonden!";
} catch (PDOException $e) {
    echo "❌ Verbinding is mislukt: " . $e->getMessage();
}
