let activePlayer = 1;
let moveMade = false;
let player1Name = '';
let player2Name = '';
let ws;

const player1 = document.getElementById('gracz1');
const player2 = document.getElementById('gracz2');
const winMessage = document.getElementById('komunikatWygranej');
const newGameButton = document.getElementById('przyciskNowaGra');
const nextPlayerButton = document.getElementById('przyciskNastepnyGracz');

// Funkcja inicjująca połączenie WebSocket
function initWebSocket() {
    ws = new WebSocket('ws://localhost:8080');

    ws.onopen = function (event) {
        console.log('Połączono z serwerem WebSocket');
    };

    ws.onmessage = function (event) {
        const data = JSON.parse(event.data);
        console.log('Otrzymano wiadomość:', data);

        // Przykładowa logika: aktualizacja planszy gry na podstawie otrzymanych danych
        if (data.action === 'move') {
            // Tutaj należy zaimplementować logikę aktualizacji planszy gry na podstawie danych ruchu
            // Przykład:
            updateGameBoard(data.move);
        }
    };

    ws.onerror = function (error) {
        console.error('Błąd WebSocket:', error);
    };
}

// Funkcja wysyłająca ruch gracza do serwera WebSocket
function sendMove(move) {
    const message = {
        action: 'move',
        move: move
    };
    ws.send(JSON.stringify(message));
}

// Zaktualizowana funkcja zaznaczająca pole na planszy
function markField(fieldNumber) {
    const field = document.getElementById(`pole${fieldNumber}`);
    if (!moveMade && field.textContent === '') {
        field.textContent = activePlayer === 1 ? 'O' : 'X';
        moveMade = true;
        sendMove(fieldNumber); // Wysłanie ruchu do serwera WebSocket
        if (checkWin()) {
            endGame();
        }
    } else if (moveMade) {
        alert('Już zaznaczyłeś pole, teraz kliknij "Następny Gracz".');
    } else {
        alert('To pole jest już zajęte!');
    }
}

// Funkcja sprawdzająca warunek wygranej
function checkWin() {
    const winCombinations = [
        [1, 2, 3], [4, 5, 6], [7, 8, 9], // Poziomo
        [1, 4, 7], [2, 5, 8], [3, 6, 9], // Pionowo
        [1, 5, 9], [3, 5, 7] // Po skosie
    ];

    const symbol = activePlayer === 1 ? 'O' : 'X';

    for (let combination of winCombinations) {
        if (combination.every(number => document.getElementById(`pole${number}`).textContent === symbol)) {
            return true;
        }
    }
    return false;
}

// Zaktualizowana funkcja kończąca grę
function endGame() {
    const playerName = activePlayer === 1 ? player1Name : player2Name;
    winMessage.textContent = `Wygrywa ${playerName}`;
    newGameButton.style.display = 'block';
    nextPlayerButton.style.display = 'none';
    disableClick(); // Zablokowanie możliwości klikania po zakończeniu gry
}

// Funkcja wyłączająca możliwość klikania w pola planszy
function disableClick() {
    for (let i = 1; i <= 9; i++) {
        document.getElementById(`pole${i}`).onclick = null;
    }
}

// Funkcja resetująca grę
function newGame() {
    window.location.reload();
}

// Inicjalizacja gry po załadowaniu strony
window.onload = function () {
    // Pobranie nazw graczy i inicjacja połączenia WebSocket
    player1Name = player1.textContent.trim();
    player2Name = player2.textContent.trim();
    initWebSocket();
};
