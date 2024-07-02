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

/*
// PHP Data Objects(PDO) Sample Code:
try {
    $conn = new PDO("sqlsrv:server = tcp:developerlife2.database.windows.net,1433; Database = kolko-krzyzyk", "jfrackowiak@edu.cdv.pl", "qM@83Ha8WkB");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "jfrackowiak@edu.cdv.pl@developerlife2", "pwd" => "qM@83Ha8WkB", "Database" => "kolko-krzyzyk", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:developerlife2.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
?>

////////////////////////////////////////////////////////////
$servername = "tcp:developerlife2.database.windows.net,1433";
$username = "jfrackowiak@edu.cdv.pl";
$password = "qM@83Ha8WkB";
$dbname = "kolko-krzyzyk";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);

}

echo "connected succesfully";

$sql = "SELECT * FROM gracze ORDER BY id DESC LIMIT 2";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $gracz1 = $row['nazwa'];
    $row = $result->fetch_assoc();
    $gracz2 = $row['nazwa'];
    $response = array('gracz1' => $gracz1, 'gracz2' => $gracz2);
    echo json_encode($response);
} else {
    echo "Brak danych";
}

$conn->close();
*/


