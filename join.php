<?php
if (isset($_GET['gameId'])) {
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
    <title>Dołącz do gry</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Dołącz do gry w Kolko i Krzyzyk</h1>
        </div>
        <div class="content">
            <form action="join_process.php" method="post">
                <input type="hidden" name="gameId" value="<?php echo htmlspecialchars($gameId); ?>">
                <div class="form-group">
                    <label for="gracz2Name">Wprowadź swoją nazwę:</label>
                    <input type="text" id="gracz2Name" name="gracz2Name" class="input-field" required>
                </div>
                <button type="submit" class="button">Dołącz</button>
            </form>
        </div>
    </div>
</body>

</html>