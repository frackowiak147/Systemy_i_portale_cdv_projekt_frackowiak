// Funkcja przekazująca nazwy graczy do gry
function przekazNazwyGraczy() {
    const gracz1Name = document.getElementById('gracz1Name').value;
    const gracz2Name = document.getElementById('gracz2Name').value;

    if (gracz1Name && gracz2Name) {
        window.location.href = `gra.html?gracz1=${encodeURIComponent(gracz1Name)}&gracz2=${encodeURIComponent(gracz2Name)}`;
    } else {
        alert('Proszę wprowadzić nazwy obu graczy.');
    }
}

// Funkcja rozpoczynająca nową grę
function nowaGra() {
    // Przekierowanie do nowej gry, można tutaj wprowadzić więcej logiki
    alert("Nowa gra rozpoczyna się!");
}
// Funkcja przekazująca nazwy graczy do gry
function przekazNazwyGraczy() {
    const gracz1Name = document.getElementById('gracz1Name').value;
    const gracz2Name = document.getElementById('gracz2Name').value;

    if (gracz1Name && gracz2Name) {
        window.location.href = `gra.html?gracz1=${encodeURIComponent(gracz1Name)}&gracz2=${encodeURIComponent(gracz2Name)}`;
    } else {
        alert('Proszę wprowadzić nazwy obu graczy.');
    }
}

// Funkcja rozpoczynająca nową grę
function nowaGra() {
    // Przekierowanie do nowej gry, można tutaj wprowadzić więcej logiki
    alert("Nowa gra rozpoczyna się!");
}
