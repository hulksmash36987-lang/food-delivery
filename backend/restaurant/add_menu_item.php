<?php
require_once("../db.php");

if($_SERVER['REQUEST_METHOD'] === 'POST') {
$sql_check = "SELECT * FROM restaurants WHERE restaurant_id = $restaurant_id";
$result = $conn->query($sql_check);
if($result->num_rows == 0) {
    echo json_encode(["success"=>false,"message"=>"Restaurant not found"]);
    exit();
}
    $name = $_POST['name'];
    $price = $_POST['price'];

    $sql = "INSERT INTO menu_items (restaurant_id, name, price) VALUES ('$restaurant_id', '$name', '$price')";
    if($conn->query($sql)) {
        echo json_encode(["success" => true, "message" => "Menu item added"]);
    } else {
        echo json_encode(["success" => false, "message" => $conn->error]);
    }
}
?>
