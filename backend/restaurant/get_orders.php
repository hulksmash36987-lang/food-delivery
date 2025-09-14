<?php
require_once("../db.php");

$restaurant_id = $_GET['restaurant_id'] ?? 0;

$sql = "SELECT o.order_id, o.status, u.name AS customer_name, u.email AS customer_email, o.created_at
        FROM orders o
        JOIN users u ON o.customer_id = u.user_id
        WHERE o.restaurant_id = $restaurant_id
        ORDER BY o.created_at DESC";

$result = $conn->query($sql);

$orders = [];
while($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);
?>
