<?php
session_start();
if(isset($_SESSION['voornaam']) && isset($_SESSION['achternaam'] )){
    echo htmlspecialchars($_SESSION['voornaam'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($_SESSION['achternaam'], ENT_QUOTES, 'UTF-8');
}


$time = time();
echo date('d-m-Y H:i:s', $time);

$tools = [];
if(isset($_GET['search_submit'] )){
    if(!empty($_GET['search'])){
        require 'database.php';
        $zoekterm = $_GET['search'];
        $sql = "SELECT * FROM tools WHERE name LIKE :zoekterm";
        $result = $conn->prepare($sql);
        $result->execute([':zoekterm' => "%$zoekterm%"]);
        $tools = $result->fetchAll(PDO::FETCH_ASSOC);
    }
}


$sql = "SELECT COUNT(*) AS aantal FROM tools";
$result = $conn->query($sql);
$resultaat_array = $result->fetch(PDO::FETCH_ASSOC);
 $aantal = $resultaat_array['aantal'];
echo htmlspecialchars($aantal, ENT_QUOTES, 'UTF-8');



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gevonden tools</title>
</head>

<body>
    <div class="container">
        <form action="" method="get">
            <input type="text" name="search" id="search" placeholder="Zoek naar gereedschap">
            <button type="submit" name="search_submit">Zoek</button>
        </form>
    </div>
    <div class="container">
        <h1>Resultaten</h1>
        <?php foreach ($tools as $tool) : ?>
        <?php endforeach; ?>
    </div>
</body>

</html>