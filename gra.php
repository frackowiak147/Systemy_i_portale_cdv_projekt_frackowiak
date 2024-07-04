<?php
if (isset($_GET['gameId']) && isset($_GET['player'])) {
    $gameId = $_GET['gameId'];
    $player = $_GET['player'];

    try {
        $dsn = "sqlsrv:server = tcp:developerlife2.database.windows.net,1433; Database = kolko-krzyzyk";
        $username = "jfrackowiak@edu.cdv.pl@developerlife2";
        $password = "qM@83Ha8WkB";
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT gracz1, gracz2 FROM gry WHERE game_id = :gameId");
        $stmt->bindParam(':gameId', $gameId);
        $stmt->execute();

        $gameData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($gameData) {
            $gracz1Name = $gameData['gracz1'];
            $gracz2Name = $gameData['gracz2'];
        } else {
            echo "Nie znaleziono gry.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Błąd połączenia: " . $e->getMessage();
        exit();
    }
} else {
    echo "Nieprawidłowy link.";
    exit();
}

$symbol = ($player == 1) ? 'O' : 'X';
$graczName = ($player == 1) ? $gracz1Name : $gracz2Name;
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Gra w Kółko i Krzyżyk</title>
    <link rel="stylesheet" href="style.css">
    <script>
        const gameId = "<?php echo $gameId; ?>";
        const player = "<?php echo $player; ?>";
        const symbol = "<?php echo $symbol; ?>";

        function zaznaczPole(pole) {
            fetch('game_process.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ gameId: gameId, pole: pole, symbol: symbol })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('pole' + pole).innerText = symbol;
                        document.getElementById('komunikatWygranej').innerText = data.message;
                    } else {
                        alert(data.message);
                    }
                });
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Gra w Kółko i Krzyżyk</h1>
            <button class="exit-button" onclick="window.location.href='index.html'">X</button>
        </div>
        <div class="content">
            <h2><?php echo htmlspecialchars($graczName); ?>, grasz symbolem <?php echo $symbol; ?></h2>
            <div class="plansza-krzyzyk-container">
                <div class="plansza-krzyzyk">
                    <div id="pole1" class="pole" onclick="zaznaczPole(1)"></div>
                    <div id="pole2" class="pole" onclick="zaznaczPole(2)"></div>
                    <div id="pole3" class="pole" onclick="zaznaczPole(3)"></div>
                    <div id="pole4" class="pole" onclick="zaznaczPole(4)"></div>
                    <div id="pole5" class="pole" onclick="zaznaczPole(5)"></div>
                    <div id="pole6" class="pole" onclick="zaznaczPole(6)"></div>
                    <div id="pole7" class="pole" onclick="zaznaczPole(7)"></div>
                    <div id="pole8" class="pole" onclick="zaznaczPole(8)"></div>
                    <div id="pole9" class="pole" onclick="zaznaczPole(9)"></div>
                </div>
            </div>
            <div id="komunikatWygranej" class="komunikat"></div>
            <button id="przyciskNowaGra" class="button" onclick="nowaGra()" style="display:none;">Nowa Gra</button>
        </div>
    </div>
</body>

</html>