<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in, please login. ";
    echo "<a href='login.php'>Login here</a>";
    exit;
}

if ($_SESSION['role'] != 'admin') {
    echo "You are not allowed to view this page, please login as admin";
    exit;
}

//check method
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "You are not allowed to view this page";
    exit;
}
require 'database.php';

$name = $_POST['name'];
$category = $_POST['category'];
$price = $_POST['price'];
$brand = $_POST['brand'];
$image = $_POST['image'];


$sql = "INSERT INTO tools (tool_name, tool_category, tool_price, tool_brand, tool_image) VALUES (:name, :category, :price, :brand, :image)";
$stmt = $conn->prepare($sql);
$result = $stmt->execute([
    ':name' => $name,
    ':category' => $category,
    ':price' => $price,
    ':brand' => $brand,
    ':image' => $image
]);

if ($result) {
    header("Location: tool_index.php");
    exit;
}

echo "Something went wrong";
