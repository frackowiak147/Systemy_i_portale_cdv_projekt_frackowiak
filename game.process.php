<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $gameId = $data['gameId'];
    $pole = $data['pole'];
    $symbol = $data['symbol'];

    try {
        $dsn = "sqlsrv:server = tcp:developerlife2.database.windows.net,1433; Database = kolko-krzyzyk";
        $username = "jfrackowiak@edu.cdv.pl@developerlife2";
        $password = "qM@83Ha8WkB";
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Aktualizacja planszy w bazie danych
        $stmt = $conn->prepare("UPDATE plansza SET symbol = :symbol WHERE game_id = :gameId AND pole = :pole");
        $stmt->bindParam(':symbol', $symbol);
        $stmt->bindParam(':gameId', $gameId);
        $stmt->bindParam(':pole', $pole);
        $stmt->execute();

        // Sprawdzanie wygranej
        // Tu można dodać kod do sprawdzania wygranej i zwrócenie odpowiedniego komunikatu

        echo json_encode(['status' => 'success', 'message' => 'Ruch wykonany']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Błąd połączenia: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Nieprawidłowe żądanie']);
}
?>