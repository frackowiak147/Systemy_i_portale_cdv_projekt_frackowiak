// Inicjalizacja połączenia WebSocket
const socket = new WebSocket('ws://localhost:8080');

// Obsługa połączenia z serwerem
socket.onopen = function (event) {
    console.log('Połączono z serwerem WebSocket');
};

// Obsługa wiadomości przychodzących
socket.onmessage = function (event) {
    const data = JSON.parse(event.data);
    console.log('Otrzymano wiadomość:', data);

    // Przykładowa logika: aktualizacja planszy gry na podstawie otrzymanych danych
    if (data.action === 'updateBoard') {
        updateGameBoard(data.board);
    }
};

// Obsługa błędów
socket.onerror = function (error) {
    console.error('Błąd WebSocket:', error);
};

// Funkcja do wysyłania ruchu gracza
function sendMove(move) {
    const message = {
        action: 'move',
        move: move
    };
    socket.send(JSON.stringify(message));
}

// Przykładowa funkcja aktualizująca planszę gry
function updateGameBoard(board) {
    // Implementacja logiki aktualizacji interfejsu gry na podstawie danych planszy
    console.log('Aktualizacja planszy gry:', board);
}
