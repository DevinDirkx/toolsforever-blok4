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

$stmt = $conn->prepare("SELECT * FROM tools");
$stmt->execute();
$tools = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'header.php';
?>
<main>
    <table>
        <thead>
            <tr>
                <th>Naam</th>
                <th>Categorie</th>
                <th>Prijs</th>
                <th>Merk</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tools as $tool) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($tool['tool_name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?php echo htmlspecialchars($tool['tool_category'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?php echo htmlspecialchars($tool['tool_price'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?php echo htmlspecialchars($tool['tool_brand'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>

                        <a href="tools_detail.php?id=<?php echo htmlspecialchars($tool['tool_id'], ENT_QUOTES, 'UTF-8') ?>">Bekijk</a>
                        Wijzig
                        Verwijder
                        <!-- <a href="tools_edit.php?id=<?php echo htmlspecialchars($tool['tool_id'], ENT_QUOTES, 'UTF-8') ?>">Wijzig</a> -->
                        <a href="tools_delete.php?id=<?php echo htmlspecialchars($tool['tool_id'], ENT_QUOTES, 'UTF-8') ?>"
                        onclick="return confirm('weet je het zeker dat je deze tool wilt verwijderen?')"
                        >
                        Verwijder
                    </a> 
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
<?php require 'footer.php' ?>