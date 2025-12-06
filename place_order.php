<?php
// place_order.php
header('Content-Type: application/json');
require 'db.php';

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
    // 3. Insert into Database
    $stmt = $pdo->prepare("INSERT INTO orders (customer_name, ig_handle, phone, address, items_json, total_price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $ig_handle, $phone, $address, $items_json, $total]);
    
    $order_id = $pdo->lastInsertId();

    // 4. Send Telegram Notification
    // REPLACE THESE WITH YOUR ACTUAL CREDENTIALS
    $bot_token = "YOUR_TELEGRAM_BOT_TOKEN";
    $chat_id = "YOUR_TELEGRAM_CHAT_ID";

    if ($bot_token !== "YOUR_TELEGRAM_BOT_TOKEN") {
        $message = "🚨 *New Order Received!* 🚨\n\n";
        $message .= "🆔 Order ID: #$order_id\n";
        $message .= "👤 Name: $name\n";
        $message .= "📱 IG: @$ig_handle\n";
        $message .= "💰 Total: ₱$total\n\n";
        $message .= "📦 *Items:*\n";
        
        foreach ($items as $item) {
            $message .= "- " . $item['name'] . " (x" . $item['qty'] . ")\n";
        }

        $url = "https://api.telegram.org/bot$bot_token/sendMessage";
        $post_fields = [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'Markdown'
        ];

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $result = curl_exec($ch); 
        curl_close($ch);
    }

    echo json_encode(['success' => true, 'message' => 'Order placed successfully!', 'order_id' => $order_id]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>