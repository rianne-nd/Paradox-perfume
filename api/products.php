<?php
// api/products.php
require_once 'db.php';

header('Content-Type: application/json');

try {
    // Check if it's a POST request (Admin updating stock)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // TODO: Add Admin Authentication Check here
        
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['id'])) {
            if (isset($data['stock'])) {
                $stmt = $pdo->prepare("UPDATE products SET stock_qty = ? WHERE id = ?");
                $stmt->execute([$data['stock'], $data['id']]);
            }
            
            if (isset($data['price'])) {
                $stmt = $pdo->prepare("UPDATE products SET price = ? WHERE id = ?");
                $stmt->execute([$data['price'], $data['id']]);
            }

            echo json_encode(['success' => true, 'message' => 'Product updated']);
            exit;
        }
    }

    // Default: GET request (Fetch all active products)
    $stmt = $pdo->query("SELECT * FROM products WHERE is_active = 1");
    $products = $stmt->fetchAll();
    
    echo json_encode($products);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
