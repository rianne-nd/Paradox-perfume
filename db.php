<?php
// db.php - Database Connection File

$host = 'localhost:3307';
$db   = 'paradox_db';
$user = 'root';      // Default XAMPP user
$pass = '';          // Default XAMPP password (empty)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // In production, don't echo the error directly
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>