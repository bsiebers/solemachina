<?php
class Database {
    private $host = 'host.docker.internal'; // zodat Docker 'localhost' op jouw pc bereikt
    private $database = 'Pizzadatabase';
    private $username = 'pizzaadmin';
    private $password = 'admin';
    public $conn;

    public function getConnection() {
        try {
            $this->conn = new PDO(
                "sqlsrv:Server={$this->host};Database={$this->database};TrustServerCertificate=1",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>
