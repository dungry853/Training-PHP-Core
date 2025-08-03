<?php


namespace App\Config;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database
{
    private $connection;
    function __construct()
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();
        $host = $_ENV['DB_HOST'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $dbName = $_ENV['DB_NAME'];
        $port = $_ENV['DB_PORT'] ?? 3306;

        try {
            $connection = new PDO("mysql:host=$host;port=$port;dbname=$dbName;charset=utf8", $username, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection = $connection;
        } catch (PDOException $e) {
            die("Kết nối database thất bại: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
