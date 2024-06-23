<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "statki";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

$idWygranego = $_POST['idWygranego'];

$sql = "UPDATE gracze SET wygrana = 1 WHERE id = $idWygranego";
$conn->query($sql);

$conn->close();
?>