<?php
namespace App\Models;
use PDO;
use App\Database;

class Product
{
    public function __construct(private Database $database) {}

    public function getData(): array
    {
        $pdo = $this->database->getConnection();
        return $pdo->query("SELECT * FROM product")->fetchAll(PDO::FETCH_ASSOC);
    }
}