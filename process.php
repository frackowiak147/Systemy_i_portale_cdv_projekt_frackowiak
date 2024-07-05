<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Ustawienia bazy danych
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "kolko_krzyzyk";

        // Tworzenie połączenia
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Sprawdzenie połączenia
        if ($conn->connect_error) {
            die("Błąd połączenia: " . $conn->connect_error);
        }

        // Pobranie loginu i hasła z formularza
        $login = $_POST['login'];
        $haslo = $_POST['haslo'];

        // Zabezpieczenie przed SQL injection
        $login = htmlspecialchars($login);
        $haslo = htmlspecialchars($haslo);

        // Zapytanie SQL w celu sprawdzenia logowania
        $stmt = $conn->prepare("SELECT id FROM logins WHERE login = ? AND haslo = ?");
        $stmt->bind_param("ss", $login, $haslo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Zalogowano poprawnie
            $_SESSION['login'] = $login;
            header("Location: index2.php"); // Zmiana na PHP, aby móc odczytać sesję
            exit();
        } else {
            // Błąd logowania
            echo "Błędny login lub hasło.";
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Błąd połączenia: " . $e->getMessage();
    }
} else {
    echo "Nieprawidłowe żądanie.";
}
?>