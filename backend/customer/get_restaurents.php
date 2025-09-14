<?php
require_once("../db.php");

$result = $conn->query("SELECT * FROM restaurants");
$restaurants = [];

while ($row = $result->fetch_assoc()) {
    $restaurants[] = $row;
}

echo json_encode($restaurants);
?>
