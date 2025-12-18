<?php
// api/db.php

$host = 'sql100.infinityfree.com'; // InfinityFree Host
$db   = 'if0_40710396_paradox_db'; // InfinityFree Database Name
$user = 'if0_40710396';            // InfinityFree Username
$pass = 'YJ46RXJrEyJHisw';         // InfinityFree vPanel Password
$port = '3306';                    // Standard MySQL port
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Return JSON error if connection fails
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}
?>
