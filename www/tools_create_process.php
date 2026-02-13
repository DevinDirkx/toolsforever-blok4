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

// basic server-side validation & sanitization
$required = ['name','category','price','brand'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        $_SESSION['error'] = 'Please fill in all fields';
        header('Location: tools_create.php');
        exit;
    }
}

$name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES);
$category = htmlspecialchars(trim($_POST['category']), ENT_QUOTES);
$price_raw = trim($_POST['price']);
if (!is_numeric($price_raw) || $price_raw < 0) {
    $_SESSION['error'] = 'Price must be a positive number';
    header('Location: tools_create.php');
    exit;
}
$price = floatval($price_raw);
$brand = htmlspecialchars(trim($_POST['brand']), ENT_QUOTES);
$image = isset($_POST['image']) ? htmlspecialchars(trim($_POST['image']), ENT_QUOTES) : null;


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
