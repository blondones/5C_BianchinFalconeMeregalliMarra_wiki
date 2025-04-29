
<!--ADMIN-->

<!-- Navbar con ricerca -->
<div id="navbar-search-admin" style="display: none;">
    <nav class="navbar">
        <div class="logo">WIKI</div>
        <ul class="nav-links">
            <li><a href="../PAGINE/home.php">Home</a></li>
            <li><a href="../PAGINE/reviewer_listaBozze.php">Review</a></li>
            <li><a href="#">Write</a></li>
            <li><a href="../PAGINE/login.php">Area Utente</a></li>
        </ul>
        <div class="user-area">
             <form method="POST" action="../PAGINE/opzioniricerca.php">
                <input type="text" id="search" name="search" placeholder="Search...">
                <button type="submit"><img src="../../data/search.png" alt=""></button>
            </form>
        </div>
    </nav>
</div>

<!-- Navbar con logOut -->
<div id="navbar-logout-admin" style="display: none;">
    <nav class="navbar">
        <div class="logo">WIKI</div>
        <ul class="nav-links">
            <li><a href="../PAGINE/home.php">Home</a></li>
            <li><a href="../PAGINE/reviewer_listaBozze.php">Review</a></li>
            <li><a href="#">Write</a></li>
            <li><a href="../PAGINE/login.php">Area Utente</a></li>
        </ul>
        <div class="user-area">
            <button>LogOut</button>
        </div>
    </nav>
</div>

<!-- Navbar con Saluto -->
<div id="navbar-welcome-admin" style="display: none;">
    <nav class="navbar">
        <div class="logo">WIKI</div>
        <ul class="nav-links">
        <li><a href="../PAGINE/home.php">Home</a></li>
            <li><a href="../PAGINE/reviewer_listaBozze.php">Review</a></li>
            <li><a href="#">Write</a></li>
            <li><a href="../PAGINE/login.php">Area Utente</a></li>
        </ul>
        <div class="user-area">
            <h3>Welcome <br> Back!!!</h3>
        </div>
    </nav>
</div>


<!-- Navbar vuota -->
<div id="navbar-empty-admin" style="display: none;">
    <nav class="navbar">
        <div class="logo">WIKI</div>
        <ul class="nav-links">
        <li><a href="../PAGINE/home.php">Home</a></li>
            <li><a href="../PAGINE/reviewer_listaBozze.php">Review</a></li>
            <li><a href="#">Write</a></li>
            <li><a href="../PAGINE/login.php">Area Utente</a></li>
        </ul>
    </nav>
</div>


<!-- Navbar Scrittore , reviewer no--> 
<!-- Navbar con logOut -->
<div id="navbar-logout-writer" style="display: none;">
    <nav class="navbar">
        <div class="logo">WIKI</div>
        <ul class="nav-links">
            <li><a href="../PAGINE/home.php">Home</a></li>
            <li><a style = "color: gray; pointer-events: none; cursor: default">Review</a></li>
            <li><a href="#">Write</a></li>
            <li><a href="../PAGINE/login.php">Area Utente</a></li>
        </ul>
        <div class="user-area">
            <button>LogOut</button>
        </div>
    </nav>
</div>



<!-- Navbar Reviewer, scrittore no -->
<!-- Navbar con logOut -->
<div id="navbar-logout-reviewer" style="display: none;">
    <nav class="navbar">
        <div class="logo">WIKI</div>
        <ul class="nav-links">
            <li><a href="../PAGINE/home.php">Home</a></li>
            <li><a href="../PAGINE/reviewer_listaBozze.php">Review</a></li>
            <li><a style = "color: gray; pointer-events: none; cursor: default">Write</a></li>
            <li><a href="../PAGINE/login.php">Area Utente</a></li>
        </ul>
        <div class="user-area">
            <button>LogOut</button>
        </div>
    </nav>
</div>






<!-- Navbar User, tutti no -->
<!-- Navbar con ricerca -->
<div id="navbar-search-user" style="display: none;">
    <nav class="navbar">
        <div class="logo">WIKI</div>
        <ul class="nav-links">
            <li><a href="../PAGINE/home.php">Home</a></li>
            <li><a style = "color: gray; pointer-events: none; cursor: default">Review</a></li>
            <li><a style = "color: gray; pointer-events: none; cursor: default">Write</a></li>
            <li><a href="../PAGINE/login.php">Area Utente</a></li>
        </ul>
        <div class="user-area">
             <form action="../PAGINE/opzioniricerca.php" method="POST">
                <input type="text" id="search" name="search" placeholder="Search...">
                <button type="submit"><img src="../../data/search.png" alt=""></button>
            </form>
        </div>
    </nav>
</div>


<!-- Navbar vuota -->
<div id="navbar-empty-user" style="display: none;">
    <nav class="navbar">
        <div class="logo">WIKI</div>
        <ul class="nav-links">
        <li><a href="../PAGINE/home.php">Home</a></li>
        <li><a style = "color: gray; pointer-events: none; cursor: default">Review</a></li>
        <li><a style = "color: gray; pointer-events: none; cursor: default">Write</a></li>
            <li><a href="../PAGINE/login.php">Area Utente</a></li>
        </ul>
    </nav>
</div>