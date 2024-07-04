<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $dsn = "sqlsrv:server = tcp:developerlife2.database.windows.net,1433; Database = kolko-krzyzyk";
        $username = "jfrackowiak@edu.cdv.pl@developerlife2";
        $password = "qM@83Ha8WkB";

        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $gracz1Name = $_POST['gracz1Name'];
        $gracz2Name = $_POST['gracz2Name'];

        // Generowanie unikalnego ID gry
        $gameId = uniqid();

        // Dodawanie nazw graczy do bazy danych
        $stmt = $conn->prepare("INSERT INTO gry (game_id, gracz1, gracz2) VALUES (:gameId, :gracz1Name, :gracz2Name)");
        $stmt->bindParam(':gameId', $gameId);
        $stmt->bindParam(':gracz1Name', $gracz1Name);
        $stmt->bindParam(':gracz2Name', $gracz2Name);
        $stmt->execute();

        // Generowanie linków dla graczy
        $gracz1Link = "gra.php?gameId=" . urlencode($gameId) . "&player=1";
        $gracz2Link = "gra.php?gameId=" . urlencode($gameId) . "&player=2";

        // Przekierowanie do strony z linkami do gry
        header("Location: links.php?gracz1Link=" . urlencode($gracz1Link) . "&gracz2Link=" . urlencode($gracz2Link));
        exit();
    } catch (PDOException $e) {
        echo "Błąd połączenia: " . $e->getMessage();
    }
} else {
    echo "Nieprawidłowe żądanie";
}
?>