<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "statki";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

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
?>