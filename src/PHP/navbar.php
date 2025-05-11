<!-- navbar.php -->

<!-- ADMIN: navbar con ricerca -->
<div id="navbar-search-admin" style="display: none;">
  <nav class="navbar">
    <div class="logo">WIKI</div>
    <ul class="nav-links">
      <li><a href="../PAGINE/home.php">Home</a></li>
      <li><a href="../PAGINE/reviewer_listaBozze.php">Review</a></li>
      <li><a href="../PAGINE/writer_listaArticoli.php">Write</a></li>
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

<!-- ADMIN: navbar con logout -->
<div id="navbar-logout-admin" style="display: none;">
  <nav class="navbar">
    <div class="logo">WIKI</div>
    <ul class="nav-links">
      <li><a href="../PAGINE/home.php">Home</a></li>
      <li><a href="../PAGINE/reviewer_listaBozze.php">Review</a></li>
      <li><a href="../PAGINE/writer_listaArticoli.php">Write</a></li>
      <li><a href="../PAGINE/login.php">Area Utente</a></li>
    </ul>
    <div class="user-area">
      <a href="../PHP/logout.php">Logout</a>
    </div>
  </nav>
</div>

<!-- WRITER: navbar con logout -->
<div id="navbar-logout-writer" style="display: none;">
  <nav class="navbar">
    <div class="logo">WIKI</div>
    <ul class="nav-links">
      <li><a href="../PAGINE/home.php">Home</a></li>
      <li><a style="color: gray; pointer-events: none; cursor: default">Review</a></li>
      <li><a href="../PAGINE/writer_listaArticoli.php">Write</a></li>
      <li><a href="../PAGINE/login.php">Area Utente</a></li>
    </ul>
    <div class="user-area">
      <a href="../PHP/logout.php">Logout</a>
    </div>
  </nav>
</div>

<!-- REVIEWER: navbar con logout -->
<div id="navbar-logout-reviewer" style="display: none;">
  <nav class="navbar">
    <div class="logo">WIKI</div>
    <ul class="nav-links">
      <li><a href="../PAGINE/home.php">Home</a></li>
      <li><a href="../PAGINE/reviewer_listaBozze.php">Review</a></li>
      <li><a href="../PAGINE/writer_listaArticoli.php">Write</a></li>
      <li><a href="../PAGINE/login.php">Area Utente</a></li>
    </ul>
    <div class="user-area">
      <a href="../PHP/logout.php">Logout</a>
    </div>
  </nav>
</div>

<!-- USER (logged): navbar con ricerca -->
<div id="navbar-search-user" style="display: none;">
  <nav class="navbar">
    <div class="logo">WIKI</div>
    <ul class="nav-links">
      <li><a href="../PAGINE/home.php">Home</a></li>
      <li><a style="color: gray; pointer-events: none; cursor: default">Review</a></li>
      <li><a href="../PAGINE/writer_listaArticoli.php">Write</a></li>
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

<!-- USER (not logged): navbar vuota -->
<div id="navbar-empty-user" style="display: none;">
  <nav class="navbar">
    <div class="logo">WIKI</div>
    <ul class="nav-links">
      <li><a href="../PAGINE/home.php">Home</a></li>
      <li><a style="color: gray; pointer-events: none; cursor: default">Review</a></li>
      <li><a href="../PAGINE/writer_listaArticoli.php">Write</a></li>
      <li><a href="../PAGINE/login.php">Area Utente</a></li>
    </ul>
  </nav>
</div>
