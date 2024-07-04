<?php
if (isset($_GET['gameId']) && isset($_GET['link'])) {
    $gameId = $_GET['gameId'];
    $gameLink = $_GET['link'];
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Link do Gry</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Link do gry</h1>
        </div>
        <div class="content">
            <p>Skopiuj poniższy link i przekaż graczowi 2:</p>
            <textarea readonly><?php echo htmlspecialchars($gameLink); ?></textarea>
            <br><br>
            <a href="<?php echo htmlspecialchars($gameLink); ?>">Dołącz do gry</a>
        </div>
    </div>
</body>

</html>