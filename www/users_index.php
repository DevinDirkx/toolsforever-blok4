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
require 'database.php';

$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'header.php';
?>
<main>
    <div class="container">


        <table>
            <thead>
                <tr>
                    <th>Voornaam</th>
                    <th>Achternaam</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['firstname'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?php echo htmlspecialchars($user['lastname'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?php echo htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <a href="users_detail.php?id=<?php echo htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?>">Bekijk</a>
                            Wijzig
                      
                            <!-- <a href="users_edit.php?id=<?php echo htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?>">Wijzig</a>  -->
                            <a href="users_delete.php?id=<?php echo htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?>">Verwijder</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<?php require 'footer.php' ?>