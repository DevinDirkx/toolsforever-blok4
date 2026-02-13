<?php
session_start();
require 'database.php';


$stmt = $conn->prepare("SELECT * FROM tools");
$stmt->execute();
$tools = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'header.php';
?>


<main>
    <div class="container">

        <!-- show products here -->
        <?php foreach ($tools as $tool) : ?>
            <div class="product">
                <img src="<?php echo isset($tool['tool_image']) ? 'images/' . htmlspecialchars($tool['tool_image'], ENT_QUOTES, 'UTF-8') : 'https://placehold.co/200' ?>" alt="<?php echo htmlspecialchars($tool['tool_name'], ENT_QUOTES, 'UTF-8') ?>">
                <h3><?php echo htmlspecialchars($tool['tool_name'], ENT_QUOTES, 'UTF-8') ?></h3>
                <p>€ <?php echo number_format($tool['tool_price'] / 100, 2, ',', '') ?></p>
                <a href="tools_detail.php?id=<?php echo htmlspecialchars($tool['tool_id'], ENT_QUOTES, 'UTF-8') ?>">Bekijk</a>
            </div>

        <?php endforeach; ?>

    </div>

</main>

<?php require 'footer.php' ?>