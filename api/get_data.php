<?php
session_start();
require '../db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Stats
$stmt = $pdo->query("SELECT COUNT(*) as count, SUM(total_price) as revenue FROM orders");
$stats = $stmt->fetch();

// Orders
$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll();

echo json_encode([
    'stats' => [
        'orders' => $stats['count'],
        'revenue' => $stats['revenue'] ?? 0
    ],
    'orders' => $orders,
    'username' => $_SESSION['username']
]);
?>