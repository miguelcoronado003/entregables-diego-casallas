<?php
namespace App\Config;
use PDO;
use Exception;

class ConnectDB
{
    private $host;
    private $user;
    private $password;
    private $db;
    private $charset;
    private $dsn;
    private $pdo;

    public function __construct()
    {
        $this->host = '127.0.0.1';
        $this->user = 'root';
        $this->password = '';
        $this->db = 'crud-php-app';
        $this->charset = 'utf8mb4';
        $this->dsn = "mysql:host=$this->host; dbname=$this->db; charset=$this->charset";
    }

    public function connect()
    {
        try {
            $this->pdo = new PDO($this->dsn, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo 'Connection error: ' . $e->getMessage();
        }
        return $this->pdo;
    }
}
$conn = new ConnectDB();
$pdoConn = $conn->connect();

$sql = "SELECT * FROM user";
$result = $conn->connect();
?>