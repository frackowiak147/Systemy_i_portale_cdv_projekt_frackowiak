<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Ustawienia bazy danych
        $dsn = "sqlsrv:server =tcp:kolko-krzyzyk.database.windows.net,1433; Database = kolko_krzyzyk";
        $username = "jfrackowiak@edu.cdv.pl@kolko-krzyzyk"; // Upewnij się, że użytkownik ma odpowiednie uprawnienia
        $password = "qM@83Ha8WkB";

        // Tworzenie nowego połączenia PDO
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Usunięcie wszystkich rekordów z tabeli gracze
        $conn->exec("TRUNCATE TABLE gracze");

        // Pobieranie danych z formularza
        $gracz1Name = $_POST['gracz1Name'];
        $gracz2Name = $_POST['gracz2Name'];

        // Dodawanie nazw graczy do bazy danych
        $stmt = $conn->prepare("INSERT INTO gracze (nazwa) VALUES (:gracz1Name), (:gracz2Name)");
        $stmt->bindParam(':gracz1Name', $gracz1Name);
        $stmt->bindParam(':gracz2Name', $gracz2Name);
        $stmt->execute();

        // Przekierowanie do strony gry z nazwami graczy w parametrach URL
        header("Location: gra.php?gracz1=" . urlencode($gracz1Name) . "&gracz2=" . urlencode($gracz2Name));
        exit();
    } catch (PDOException $e) {
        echo "Błąd połączenia: " . $e->getMessage();
    }
} else {
    echo "Nieprawidłowe żądanie";
}
?>
