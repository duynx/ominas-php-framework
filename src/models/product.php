<?php

class Product
{
    public function getData(): array
    {
        $dsn = "mysql:host=localhost;dbname=ominas;charset=utf8;port=3306";

        $pdo = new PDO($dsn, "ominas_dbuser", "secret", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $stmt = $pdo->query("SELECT * FROM product");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}