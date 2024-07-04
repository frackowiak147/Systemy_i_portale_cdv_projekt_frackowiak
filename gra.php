<?php
// Połączenie z bazą danych
try {
    $dsn = "sqlsrv:server = tcp:developerlife2.database.windows.net,1433; Database = kolko-krzyzyk";
    $username = "jfrackowiak@edu.cdv.pl@developerlife2";
    $password = "qM@83Ha8WkB";
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Pobieranie nazw graczy
    $stmt = $conn->query("SELECT nazwa FROM gracze");
    $gracze = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Sprawdzanie czy rekordy istnieją
    if (count($gracze) >= 2) {
        $gracz1Name = $gracze[0]['nazwa'];
        $gracz2Name = $gracze[1]['nazwa'];
    } else {
        $gracz1Name = "Gracz 1"; // Domyślne wartości w przypadku braku danych
        $gracz2Name = "Gracz 2";
    }
} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
    exit();
}

$gracz1Name = isset($_GET['gracz1']) ? htmlspecialchars($_GET['gracz1']) : "Gracz 1";
$gracz2Name = isset($_GET['gracz2']) ? htmlspecialchars($_GET['gracz2']) : "Gracz 2";
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Gra w Kółko i Krzyżyk</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Gra w Kółko i Krzyżyk</h1>
            <button class="exit-button" onclick="powrotDoIndex()">X</button>
            <button type="button" onclick="alert('index.html')">X</button>
        </div>
        <div class="content">
            <h2 id="gracz1" class="nazwa-gracza"><?php echo htmlspecialchars($gracz1Name); ?></h2>
            <h2 id="gracz2" class="nazwa-gracza"><?php echo htmlspecialchars($gracz2Name); ?></h2>
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
            <button id="przyciskNastepnyGracz" class="button" onclick="następnyGracz()">Następny Gracz</button>
        </div>
    </div>

    <script src="gra.js"></script>
</body>

</html>
