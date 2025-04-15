<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviewer Lista Bozze</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <!--NAVBAR-->
    <div id="navbar-container" data-navbar="navbar-logout-RW"></div>


    <h1>Reviews</h1>
    <div class="role-container">
        <div class="role-info">
            <p>Commit Name</p>
        </div>
        <form action="../PHP/reviewerHandling.php" method="POST">
            <div class="role-buttons">
                <button id="bottoneReview">Check</button>
            </div>
        </form>
            
    </div>
    

    <script src="../JS/navbar.js"></script>
</body>
</html>
