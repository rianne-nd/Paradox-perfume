<?php
// api/orders.php
require_once 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate input
        if (!isset($data['customer']) || !isset($data['cart'])) {
            throw new Exception("Invalid order data");
        }

        $pdo->beginTransaction();

        // 1. Insert into Orders
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, phone, ig_handle, address, total_amount, payment_method) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['customer']['name'],
            $data['customer']['phone'],
            $data['customer']['ig'],
            $data['customer']['address'],
            $data['total'],
            $data['payment_method'] ?? 'Cash on Delivery'
        ]);
        
        $orderId = $pdo->lastInsertId();

        // 2. Insert into Order Items
        $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name_snapshot, quantity, price_at_purchase) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($data['cart'] as $item) {
            $stmtItem->execute([
                $orderId,
                $item['id'],
                $item['name'],
                $item['quantity'],
                $item['price']
            ]);
        }

        $pdo->commit();

        echo json_encode(['success' => true, 'order_id' => $orderId]);

    } catch (Exception $e) {
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    // GET request (Admin fetching orders)
    // TODO: Add Admin Auth Check
    $stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
    echo json_encode($stmt->fetchAll());
}
?>
