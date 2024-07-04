<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Ustawienia bazy danych
        $dsn = "sqlsrv:server = tcp:developerlife2.database.windows.net,1433; Database = kolko-krzyzyk";
        $username = "jfrackowiak@edu.cdv.pl@developerlife2"; // Upewnij się, że użytkownik ma odpowiednie uprawnienia
        $password = "qM@83Ha8WkB";

        // Tworzenie nowego połączenia PDO
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Usunięcie wszystkich rekordów z tabeli gracze
        $conn->exec("TRUNCATE TABLE gracze");

        // Pobieranie danych z formularza
        $gracz1Name = $_POST['gracz1Name'];
        $gracz2Name = $_POST['gracz2Name'];

        // Generowanie unikalnego ID gry
        $gameId = uniqid();

        // Dodawanie nazw graczy do bazy danych w osobnych zapytaniach
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

        // Przekierowanie do strony z linkiem do gry dla gracza 2
        header("Location: link_do_gry.php?gameId=" . urlencode($gameId) . "&link=" . urlencode($gameLink));
        exit();
    } catch (PDOException $e) {
        echo "Błąd połączenia: " . $e->getMessage();
    }
} else {
    echo "Nieprawidłowe żądanie";
}
?>