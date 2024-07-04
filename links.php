<?php
$gracz1Link = isset($_GET['gracz1Link']) ? htmlspecialchars($_GET['gracz1Link']) : '#';
$gracz2Link = isset($_GET['gracz2Link']) ? htmlspecialchars($_GET['gracz2Link']) : '#';
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Linki do Gry</title>
</head>

<body>
    <h1>Linki do Gry</h1>
    <p>Link dla Gracza 1: <a href="<?php echo $gracz1Link; ?>">Gracz 1 - Kliknij tutaj</a></p>
    <p>Link dla Gracza 2: <a href="<?php echo $gracz2Link; ?>">Gracz 2 - Kliknij tutaj</a></p>
</body>

</html>