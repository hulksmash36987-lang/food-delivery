<?php
header("Content-Type: application/json");
require_once("../db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'] ?? 0;
    $delivery_address = $_POST['delivery_address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $notes = $_POST['notes'] ?? '';
    
    if (!$customer_id || !$delivery_address || !$phone) {
        echo json_encode(["success" => false, "message" => "Missing required fields"]);
        exit;
    }

    // Get cart items
    $cart_sql = "SELECT c.menu_item_id, c.quantity, m.price, m.restaurant_id
                 FROM cart c
                 JOIN menu_items m ON c.menu_item_id = m.menu_item_id
                 WHERE c.customer_id = ?";
    
    $cart_stmt = $conn->prepare($cart_sql);
    $cart_stmt->bind_param("i", $customer_id);
    $cart_stmt->execute();
    $cart_result = $cart_stmt->get_result();
    
    if ($cart_result->num_rows === 0) {
        echo json_encode(["success" => false, "message" => "Cart is empty"]);
        exit;
    }
    
    // Group by restaurant
    $restaurants = [];
    $total = 0;
    
    while($item = $cart_result->fetch_assoc()) {
        $restaurant_id = $item['restaurant_id'];
        if (!isset($restaurants[$restaurant_id])) {
            $restaurants[$restaurant_id] = [];
        }
        $restaurants[$restaurant_id][] = $item;
        $total += $item['price'] * $item['quantity'];
    }
    
    // Create orders for each restaurant
    foreach($restaurants as $restaurant_id => $items) {
        $restaurant_total = 0;
        foreach($items as $item) {
            $restaurant_total += $item['price'] * $item['quantity'];
        }
        
        // Create order
        $order_sql = "INSERT INTO orders (customer_id, restaurant_id, total_amount, delivery_address, phone, notes) VALUES (?, ?, ?, ?, ?, ?)";
        $order_stmt = $conn->prepare($order_sql);
        $order_stmt->bind_param("iidsss", $customer_id, $restaurant_id, $restaurant_total, $delivery_address, $phone, $notes);
        $order_stmt->execute();
        $order_id = $conn->insert_id;
        
        // Add order items
        foreach($items as $item) {
            $item_sql = "INSERT INTO order_items (order_id, menu_item_id, quantity, price) VALUES (?, ?, ?, ?)";
            $item_stmt = $conn->prepare($item_sql);
            $item_stmt->bind_param("iiid", $order_id, $item['menu_item_id'], $item['quantity'], $item['price']);
            $item_stmt->execute();
            $item_stmt->close();
        }
        $order_stmt->close();
    }
    
    // Clear cart
    $clear_sql = "DELETE FROM cart WHERE customer_id = ?";
    $clear_stmt = $conn->prepare($clear_sql);
    $clear_stmt->bind_param("i", $customer_id);
    $clear_stmt->execute();
    $clear_stmt->close();
    
    $cart_stmt->close();
    echo json_encode(["success" => true, "message" => "Order placed successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
$conn->close();
?>