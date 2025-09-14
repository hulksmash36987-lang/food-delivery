<?php
header("Content-Type: application/json");
require_once("../db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'] ?? 0;
    
    if (!$cart_id) {
        echo json_encode(["success" => false, "message" => "Cart ID required"]);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM cart WHERE cart_id = ?");
    $stmt->bind_param("i", $cart_id);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Item removed from cart"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to remove item"]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
$conn->close();
?>