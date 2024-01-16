<?php
namespace App;
use PDO;

class Database
{
    public function getConnection(): PDO
    {
        $dsn = "mysql:host=localhost;dbname=ominas;charset=utf8;port=3306";

        return new PDO($dsn, "ominas_dbuser", "secret", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}
