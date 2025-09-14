<?php
header("Content-Type: application/json");
require_once("../db.php");

$customer_id = $_GET['customer_id'] ?? 0;

if (!$customer_id) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT c.cart_id, c.quantity, m.name, m.price, m.restaurant_id, r.name as restaurant_name
        FROM cart c
        JOIN menu_items m ON c.menu_item_id = m.menu_item_id
        JOIN restaurants r ON m.restaurant_id = r.restaurant_id
        WHERE c.customer_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

$cart = [];
while($row = $result->fetch_assoc()) {
    $cart[] = $row;
}

$stmt->close();
echo json_encode($cart);
$conn->close();
?>