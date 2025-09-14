<?php
require_once("../db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $restaurant_id = $_POST['restaurant_id'] ?? 0;
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $description = $_POST['description'] ?? '';
    $category = $_POST['category'] ?? '';
    
    if (!$restaurant_id || !$name || !$price) {
        echo json_encode(["success" => false, "message" => "All fields are required"]);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO menu_items (restaurant_id, name, description, price, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issds", $restaurant_id, $name, $description, $price, $category);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Menu item added"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add menu item"]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
$conn->close();
?>
