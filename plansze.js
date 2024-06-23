// Funkcja do generowania planszy
function generujPlansze() {
    for (let i = 1; i <= 9; i++) {
        let pole = document.getElementById('pole' + i);
        pole.innerHTML = '';
        pole.addEventListener('click', klikPole);
    }
}

// Funkcja obsługująca kliknięcia na planszy
function klikPole(event) {
    if (event.target.innerHTML === '') {
        event.target.innerHTML = 'X'; // Przykładowo dodajemy X
    }
}

// Funkcja do rozpoczęcia nowej gry
function nowaGra() {
    generujPlansze();
}

// Generowanie planszy przy ładowaniu strony
window.onload = generujPlansze;
