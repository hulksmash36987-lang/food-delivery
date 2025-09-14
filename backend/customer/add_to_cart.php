<?php
header("Content-Type: application/json");
require_once("../db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'] ?? 0;
    $menu_item_id = $_POST['menu_item_id'] ?? 0;
    $quantity = $_POST['quantity'] ?? 1;
    
    if (!$customer_id || !$menu_item_id) {
        echo json_encode(["success" => false, "message" => "Missing required fields"]);
        exit;
    }

    // Check if item already in cart
    $check = $conn->prepare("SELECT cart_id, quantity FROM cart WHERE customer_id = ? AND menu_item_id = ?");
    $check->bind_param("ii", $customer_id, $menu_item_id);
    $check->execute();
    $result = $check->get_result();
    
    if ($result->num_rows > 0) {
        // Update quantity
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;
        $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ?");
        $update->bind_param("ii", $new_quantity, $row['cart_id']);
        $update->execute();
        $update->close();
    } else {
        // Add new item
        $insert = $conn->prepare("INSERT INTO cart (customer_id, menu_item_id, quantity) VALUES (?, ?, ?)");
        $insert->bind_param("iii", $customer_id, $menu_item_id, $quantity);
        $insert->execute();
        $insert->close();
    }
    
    $check->close();
    echo json_encode(["success" => true, "message" => "Item added to cart"]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
$conn->close();
?>