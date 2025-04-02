
// Prende il valore dal data-navbar
function getNavbarType() {
    var container = document.getElementById("navbar-container");
    return container ? container.getAttribute("data-navbar") : "navbar-search"; // Default se non è specificato
}

// Carica dinamicamente la navbar
fetch('../HTML/navbar.html')
    .then(response => response.text())
    .then(data => {
        document.getElementById('navbar-container').innerHTML = data;

        // Dopo il caricamento, mostra solo la navbar scelta
        mostraNavbar(getNavbarType());
    })
    .catch(error => console.error('Errore nel caricare la navbar:', error));

// Funzione per mostrare solo la navbar selezionata
function mostraNavbar(tipo) {
    var navbars = ["navbar-search", "navbar-logout", "navbar-welcome", "navbar-empty"];

    for (var i = 0; i < navbars.length; i++) {
        var navbar = document.getElementById(navbars[i]);
        if (navbar) {
            navbar.style.display = "none";
        }
    }

    var navbarDaMostrare = document.getElementById(tipo);
    if (navbarDaMostrare) {
        navbarDaMostrare.style.display = "block";
    }
}

