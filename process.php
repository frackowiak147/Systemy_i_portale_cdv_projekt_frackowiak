<?php
echo "cos";

try {
    $dsn = "sqlsrv:server = tcp:developerlife2.database.windows.net,1433; Database = kolko-krzyzyk";
    $username = "jfrackowiak@edu.cdv.pl"; // Spróbuj użyć tylko nazwy użytkownika, bez domeny
    $password = "qM@83Ha8WkB";

    // Tworzenie nowego połączenia PDO
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   

    // Zapytanie SQL
    $sql = "SELECT TOP 2 * FROM gracze ORDER BY id DESC";
    $stmt = $conn->query($sql);
    
    // Fetchowanie danych
    $gracze = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($gracze) > 0) {
        $response = array(
            'gracz1' => isset($gracze[0]['nazwa']) ? $gracze[0]['nazwa'] : 'Brak nazwy',
            'gracz2' => isset($gracze[1]['nazwa']) ? $gracze[1]['nazwa'] : 'Brak nazwy'
        );
        echo json_encode($response);
    } else {
        echo json_encode(array('error' => 'Brak danych'));
    }
} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
}
?>




