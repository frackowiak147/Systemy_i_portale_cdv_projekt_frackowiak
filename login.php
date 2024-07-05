<?php
session_start();

// Sprawdzanie poprawności logowania
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sprawdzenie czy login i hasło są poprawne
    if ($username === 'jan' && $password === '1234') {
        // Ustawienie sesji lub ciasteczka, aby zalogować użytkownika
        $_SESSION['loggedIn'] = true;

        // Przekierowanie na stronę index.html
        header("Location: index2.html");
        exit();
    } else {
        // Przekierowanie z powrotem do formularza logowania w razie błędnego logowania
        header("Location: index.html");
        exit();
    }
}
?>
