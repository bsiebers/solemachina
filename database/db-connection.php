<?php
class Database {
    private static $host = 'host.docker.internal';
    private static $database = 'Pizzadatabase';
    private static $username = 'pizzaadmin';
    private static $password = 'admin';
    private static $conn;

    public static function getConnection() {
        try {
            if (!self::$conn) {
                self::$conn = new PDO(
                    "sqlsrv:Server=" . self::$host . ";Database=" . self::$database . ";TrustServerCertificate=1",
                    self::$username,
                    self::$password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        return self::$conn;
    }
}
?>
