<?php

session_start();

require 'database.php';


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

// basic server-side validation & sanitization
$required = ['firstname','lastname','email','password','role','address','city','backgroundColor','font'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        $_SESSION['error'] = 'Please fill in all fields';
        header('Location: users_create.php');
        exit;
    }
}

$email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
if (!$email) {
    $_SESSION['error'] = 'Invalid email address';
    header('Location: users_create.php');
    exit;
}

$password_raw = $_POST['password'];
if (strlen($password_raw) < 6) {
    $_SESSION['error'] = 'Password must be at least 6 characters';
    header('Location: users_create.php');
    exit;
}


$firstname = htmlspecialchars(trim($_POST['firstname']), ENT_QUOTES);
$lastname = htmlspecialchars(trim($_POST['lastname']), ENT_QUOTES);
$role = in_array($_POST['role'], ['admin','user']) ? $_POST['role'] : 'user';
$address = htmlspecialchars(trim($_POST['address']), ENT_QUOTES);
$city = htmlspecialchars(trim($_POST['city']), ENT_QUOTES);
$backgroundColor = htmlspecialchars(trim($_POST['backgroundColor']), ENT_QUOTES);
$font = htmlspecialchars(trim($_POST['font']), ENT_QUOTES);
$is_active = 1;

$sql = "INSERT INTO users (email, password, firstname, lastname, role, address, city, is_active) VALUES (:email, :password, :firstname, :lastname, :role, :address, :city, :is_active)";
$stmt = $conn->prepare($sql);
$result = $stmt->execute([
    ':email' => $email,
    ':password' => $password_hash($password, PASSWORD_DEFAULT),
    ':firstname' => $firstname,
    ':lastname' => $lastname,
    ':role' => $role,
    ':address' => $address,
    ':city' => $city,
    ':is_active' => $is_active
]);

if ($result) {
    $user_id = $conn->lastInsertId();
    $sql = "INSERT INTO user_settings (user_id, backgroundColor, font) VALUES (:user_id, :backgroundColor, :font)";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([
        ':user_id' => $user_id,
        ':backgroundColor' => $backgroundColor,
        ':font' => $font
    ]);
    if ($result) {
        header("Location: users_index.php");
        exit;
    } else {
        $_SESSION['error'] = 'Could not save user settings';
        header('Location: users_create.php');
        exit;
    }
}

$_SESSION['error'] = 'Could not create user';
header('Location: users_create.php');
exit;
