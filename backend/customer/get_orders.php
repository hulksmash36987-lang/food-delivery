<?php
header("Content-Type: application/json");
require_once("../db.php");

$customer_id = $_GET['customer_id'] ?? 0;

if (!$customer_id) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT o.order_id, o.total_amount, o.status, o.created_at, r.name as restaurant_name
        FROM orders o
        JOIN restaurants r ON o.restaurant_id = r.restaurant_id
        WHERE o.customer_id = ?
        ORDER BY o.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

$stmt->close();
echo json_encode($orders);
$conn->close();
?>