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
        $gracz1Name = $_POST['gracz1Name'];
        $gracz2Name = $_POST['gracz2Name'];

        // Sprawdzanie, czy istnieją już jakieś rekordy w tabeli gracze
        $sqlCheck = "SELECT COUNT(*) as liczba FROM gracze";
        $stmtCheck = $conn->query($sqlCheck);
        $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($result['liczba'] == 0) {
            // Jeśli nie ma żadnych rekordów, dodajemy nowych graczy
            $sqlInsert = "INSERT INTO gracze (nazwa, wygrana) VALUES (:gracz1Name, 0), (:gracz2Name, 0)";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bindParam(':gracz1Name', $gracz1Name);
            $stmtInsert->bindParam(':gracz2Name', $gracz2Name);
            $stmtInsert->execute();

            // Przekierowanie do strony gry z nazwami graczy w parametrach URL
            header("Location: gra.php?gracz1=" . urlencode($gracz1Name) . "&gracz2=" . urlencode($gracz2Name));
            exit();
        } else {
            // Jeśli są już rekordy, pobieramy je i przekierowujemy do gry
            $sqlSelect = "SELECT TOP 2 * FROM gracze ORDER BY id ASC";
            $stmtSelect = $conn->query($sqlSelect);
            $gracze = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

            // Pobieranie nazw graczy z bazy danych
            $gracz1DB = $gracze[0]['nazwa'];
            $gracz2DB = $gracze[1]['nazwa'];

            // Przekierowanie do strony gry z nazwami graczy pobranymi z bazy danych
            header("Location: gra.html?gracz1=" . urlencode($gracz1DB) . "&gracz2=" . urlencode($gracz2DB));
            exit();
        }
    } catch (PDOException $e) {
        echo "Błąd połączenia: " . $e->getMessage();
    }
} else {
    echo "Nieprawidłowe żądanie";
}
