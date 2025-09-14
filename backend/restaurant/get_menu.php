<?php
header('Content-Type: application/json');
require_once("../db.php");

$restaurant_id = $_GET['restaurant_id'] ?? 0;
$sql = "SELECT * FROM menu_items WHERE restaurant_id = $restaurant_id";
$result = $conn->query($sql);

$menu = [];
while($row = $result->fetch_assoc()) {
    $menu[] = $row;
}

echo json_encode($menu);
?>
