<?php
if (isset($_GET['link'])) {
    $link = $_GET['link'];
    $gameId = $_GET['gameId'];
} else {
    echo "Nieprawidłowy link.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Link do gry</title>
</head>

<body>
    <h1>Link do gry dla Gracza 2:</h1>
    <p><a href="<?php echo htmlspecialchars($link); ?>"><?php echo htmlspecialchars($link); ?></a></p>
    <p>Udostępnij ten link Graczowi 2, aby mógł dołączyć do gry.</p>
</body>

</html>