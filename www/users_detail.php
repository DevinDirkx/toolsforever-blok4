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

$id = $_GET['id'];

$sql = "SELECT * FROM users LEFT JOIN user_settings ON user_settings.user_id = users.id WHERE users.id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


require 'header.php';

?>

<main>
    <div class="container">
        <?php if (isset($user)) : ?>
            <div class="user-detail">
                <h3><?php echo htmlspecialchars($user['firstname'], ENT_QUOTES, 'UTF-8') ?></h3>
                <p><?php echo htmlspecialchars($user['lastname'], ENT_QUOTES, 'UTF-8') ?></p>
                <p><?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></p>
                <p><?php echo htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8') ?></p>
                <p><?php echo htmlspecialchars($user['address'], ENT_QUOTES, 'UTF-8') ?></p>
                <p><?php echo htmlspecialchars($user['city'], ENT_QUOTES, 'UTF-8') ?></p>
                <p><?php echo $user['is_active'] == 1 ? "is actief" : "Is niet actief"  ?></p>
                <p><?php echo htmlspecialchars($user['backgroundColor'], ENT_QUOTES, 'UTF-8') ?></p>
                <p><?php echo htmlspecialchars($user['font'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php else : ?>
                Geen gebruiker gevonden
            <?php endif; ?>
</main>
<?php require 'footer.php' ?>