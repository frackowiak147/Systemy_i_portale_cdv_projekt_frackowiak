let aktywnyGracz = 1;
let ruchWykonany = false;
let gracz1Nazwa = '';
let gracz2Nazwa = '';

const gracz1 = document.getElementById('gracz1');
const gracz2 = document.getElementById('gracz2');
const komunikatWygranej = document.getElementById('komunikatWygranej');
const przyciskNowaGra = document.getElementById('przyciskNowaGra');
const przyciskNastepnyGracz = document.getElementById('przyciskNastepnyGracz');

// Podświetlanie aktywnego gracza
function podswietlAktywnegoGracza() {
    if (aktywnyGracz === 1) {
        gracz1.style.color = 'red';
        gracz2.style.color = 'black';
    } else {
        gracz1.style.color = 'black';
        gracz2.style.color = 'green';
    }
}

// Zmiana aktywnego gracza
function następnyGracz() {
    if (ruchWykonany) {
        aktywnyGracz = aktywnyGracz === 1 ? 2 : 1;
        ruchWykonany = false;
        podswietlAktywnegoGracza();
    } else {
        alert('Musisz zaznaczyć pole przed zmianą gracza!');
    }
}

// Zaznacz pole
function zaznaczPole(numerPola) {
    const pole = document.getElementById(`pole${numerPola}`);
    if (!ruchWykonany && pole.textContent === '') {
        pole.textContent = aktywnyGracz === 1 ? 'O' : 'X';
        ruchWykonany = true;
        if (sprawdzWygrana()) {
            koniecGry();
        }
    } else if (ruchWykonany) {
        alert('Już zaznaczyłeś pole, teraz kliknij "Następny Gracz".');
    } else {
        alert('To pole jest już zajęte!');
    }
}

// Kiedy wygrana?
function sprawdzWygrana() {
    const wygraneKombinacje = [
        [1, 2, 3], [4, 5, 6], [7, 8, 9], // Poziomo
        [1, 4, 7], [2, 5, 8], [3, 6, 9], // Pionowo
        [1, 5, 9], [3, 5, 7] // Po skosie
    ];

    const symbol = aktywnyGracz === 1 ? 'O' : 'X';

    for (let kombinacja of wygraneKombinacje) {
        if (kombinacja.every(numer => document.getElementById(`pole${numer}`).textContent === symbol)) {
            return true;
        }
    }
    return false;
}

// Koniec gry
function koniecGry() {
    const nazwaGracza = aktywnyGracz === 1 ? gracz1Nazwa : gracz2Nazwa;
    komunikatWygranej.textContent = `Wygrywa ${nazwaGracza}`;
    przyciskNowaGra.style.display = 'block';
    przyciskNastepnyGracz.style.display = 'none';
    wyłączKlikanie();
    zapiszWynik(aktywnyGracz); // Zapisz wynik do bazy danych
}

// Zakaz klikania
function wyłączKlikanie() {
    for (let i = 1; i <= 9; i++) {
        document.getElementById(`pole${i}`).onclick = null;
    }
}

// Powrót do strony głównej
function powrotDoIndex() {
    window.location.href = 'index.html';
}

// Funkcja do pobierania nazw graczy z bazy danych
function pobierzNazwyGraczy() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'pobierz_nazwy_graczy.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            gracz1Nazwa = response.gracz1;
            gracz2Nazwa = response.gracz2;
            gracz1.textContent = gracz1Nazwa;
            gracz2.textContent = gracz2Nazwa;
            podswietlAktywnegoGracza();
        }
    };
    xhr.send();
}

// Funkcja do zapisywania wyniku do bazy danych
function zapiszWynik(idWygranego) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'zapisz_wynik.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log('Wynik został zapisany.');
        }
    };
    xhr.send(`idWygranego=${idWygranego}`);
}

// Funkcja resetująca grę
function nowaGra() {
    window.location.reload();
    window.location.href = 'index2.html';
}

// Inicjalizacja gry
pobierzNazwyGraczy();
