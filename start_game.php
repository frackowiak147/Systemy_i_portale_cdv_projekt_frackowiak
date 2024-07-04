<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Ustawienia bazy danych
        $dsn = "sqlsrv:server = tcp:developerlife2.database.windows.net,1433; Database = kolko-krzyzyk";
        $username = "jfrackowiak@edu.cdv.pl@developerlife2";
        $password = "qM@83Ha8WkB";

        // Tworzenie nowego połączenia PDO
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Pobieranie danych z formularza
        $gameId = $_POST['gameId'];
        $gracz2Name = $_POST['gracz2Name'];

        // Aktualizacja nazwy gracza 2 w bazie danych
        $stmt = $conn->prepare("UPDATE gracze SET nazwa = :gracz2Name WHERE gra_id = :gameId AND nazwa = ''");
        $stmt->bindParam(':gracz2Name', $gracz2Name);
        $stmt->bindParam(':gameId', $gameId);
        $stmt->execute();

        // Przekierowanie gracza 2 do strony gry
        header("Location: gra.php?gameId=" . urlencode($gameId));
        exit();
    } catch (PDOException $e) {
        echo "Błąd połączenia: " . $e->getMessage();
    }
} else {
    echo "Nieprawidłowe żądanie";
}

?>