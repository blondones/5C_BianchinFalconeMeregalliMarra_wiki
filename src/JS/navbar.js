function getNavbarType() {
    let container = document.getElementById("navbar-container");
    return container ? container.getAttribute("data-navbar") : "navbar-search";
}

fetch('../PHP/navbar.php')
    .then(response => response.text())
    .then(data => {
        document.getElementById('navbar-container').innerHTML = data;

        mostraNavbar(getNavbarType());
    })
    .catch(error => console.error('Errore nel caricare la navbar:', error));

function mostraNavbar(tipo) {
    let navbars = ["navbar-search", "navbar-logout", "navbar-welcome", "navbar-empty"];

    for (let i = 0; i < navbars.length; i++) {
        let navbar = document.getElementById(navbars[i]);
        if (navbar) {
            navbar.style.display = "none";
        }
    }

    let navbarDaMostrare = document.getElementById(tipo);
    if (navbarDaMostrare) {
        navbarDaMostrare.style.display = "block";
    }
}

