<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>


<body>
    <div id="navbar-container" data-navbar="navbar-search-user"></div>


   


    <h1 id="scrittaReviewEffettiva">I Varani: Giganti Antichi tra Mito e Natura</h1>
    <p id="testoReview1">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat ullam vel ipsam excepturi quam ad, quae error omnis ea, aut repellat at voluptatem nam. Optio placeat natus quibusdam rem fuga.</p>
    <img src="https://www.gannett-cdn.com/authoring/2011/01/27/NCOU/ghows-DA-7f3cea74-5a72-4ac7-99f5-2add0ccea1e0-b7824ad2.jpeg?crop=1886,1066,x0,y0&width=2560" alt="immagineVarano" id ="immagineVarano">
   
    <br><br><br><br><br><br><br>
    <hr>
    <br><br><br>


    <img src="https://www.gannett-cdn.com/authoring/2011/01/27/NCOU/ghows-DA-7f3cea74-5a72-4ac7-99f5-2add0ccea1e0-b7824ad2.jpeg?crop=1886,1066,x0,y0&width=2560" alt="immagineVarano2" id ="immagineVarano2">
    <p id="testoReview2">Lorem vhnfkd,cbdfjkcvhnjrj,nvhkdnhjdchnsit amet consectetur adipisicing elit. Ipsum ratione dicta facilis deleniti in consequuntur laudantium consequatur quae. Unde animi voluptatum ad architecto nesciunt! Molestiae explicabo dicta eveniet cum perferendis.</p>
     
    <script src="../JS/navbar.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    const searchForm = document.querySelector("form"); // Seleziona il form della navbar
    const searchInput = searchForm.querySelector("input[name='search']"); // Input del modulo
    const articleContainer = document.getElementById("articleContainer"); // Contenitore per l'articolo


    searchForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Previene il comportamento predefinito del form


        const searchValue = searchInput.value;


        fetch("../PHP/opzioniRicerca.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `search=${encodeURIComponent(searchValue)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                articleContainer.innerHTML = `<p>${data.error}</p>`;
            } else {
                articleContainer.innerHTML = `
                    <h1>${data.titolo}</h1>
                    <p>${data.contenuto}</p>
                `;
            }
        })
        .catch(error => {
            console.error("Errore:", error);
            articleContainer.innerHTML = `<p>Si è verificato un errore.</p>`;
        });
    });
});
</script>


    <div id="articleContainer"></div> <!-- Contenitore per l'articolo -->
    <script src="../JS/navbar.js"></script>
</body>
</html>