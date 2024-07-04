<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $dsn = "sqlsrv:server = tcp:developerlife2.database.windows.net,1433; Database = kolko-krzyzyk";
        $username = "jfrackowiak@edu.cdv.pl@developerlife2";
        $password = "qM@83Ha8WkB";

        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Usunięcie wszystkich rekordów z tabeli gracze
        $conn->exec("TRUNCATE TABLE gracze");

        $gracz1Name = $_POST['gracz1Name'];
        $gracz2Name = $_POST['gracz2Name'];

        // Generowanie unikalnego ID gry
        $gameId = uniqid();

        // Dodawanie nazw graczy do bazy danych
        $stmt1 = $conn->prepare("INSERT INTO gracze (nazwa, gra_id) VALUES (:gracz1Name, :gameId)");
        $stmt2 = $conn->prepare("INSERT INTO gracze (nazwa, gra_id) VALUES (:gracz2Name, :gameId)");

        $stmt1->bindParam(':gracz1Name', $gracz1Name);
        $stmt1->bindParam(':gameId', $gameId);

        $stmt2->bindParam(':gracz2Name', $gracz2Name);
        $stmt2->bindParam(':gameId', $gameId);

        $stmt1->execute();
        $stmt2->execute();

        // Generowanie linku dla gracza 2
        $gameLink = "https://your-app-service.azurewebsites.net/join.php?gameId=" . urlencode($gameId);

        // Przekierowanie gracza 1 do planszy gry
        header("Location: gra.php?gameId=" . urlencode($gameId) . "&gracz1=" . urlencode($gracz1Name));
        exit();
    } catch (PDOException $e) {
        echo "Błąd połączenia: " . $e->getMessage();
    }
} else {
    echo "Nieprawidłowe żądanie";
}
?>