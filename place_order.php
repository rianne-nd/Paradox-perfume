<?php
// place_order.php
header('Content-Type: application/json');
require 'api/db.php';

// 1. Get the raw POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid data received']);
    exit;
}

// 2. Extract variables
$name = $data['name'] ?? 'Guest';
$ig_handle = $data['ig_handle'] ?? '';
$phone = $data['phone'] ?? '';
$address = $data['address'] ?? '';
$items = $data['items'] ?? []; // Array of items
$total = $data['total'] ?? 0;

// Convert items to JSON for storage
$items_json = json_encode($items);

try {
    $pdo->beginTransaction();

    // Check stock and deduct
    foreach ($items as $item) {
        $stmt = $pdo->prepare("SELECT stock_qty FROM products WHERE id = ? FOR UPDATE");
        $stmt->execute([$item['id']]);
        $product = $stmt->fetch();

        if (!$product || $product['stock_qty'] < $item['qty']) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => "Insufficient stock for " . $item['name']]);
            exit;
        }

        $update = $pdo->prepare("UPDATE products SET stock_qty = stock_qty - ? WHERE id = ?");
        $update->execute([$item['qty'], $item['id']]);
    }

    // 3. Insert into Database
    $stmt = $pdo->prepare("INSERT INTO orders (customer_name, ig_handle, phone, address, items_json, total_price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $ig_handle, $phone, $address, $items_json, $total]);
    
    $order_id = $pdo->lastInsertId();
    $pdo->commit();


    echo json_encode(['success' => true, 'message' => 'Order placed successfully!', 'order_id' => $order_id]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>