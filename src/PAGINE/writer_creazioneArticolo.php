<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>
    <!--NAVBAR-->
    <div id="navbar-container" data-navbar="navbar-logout-<?php echo $_SESSION["user_role"]; ?>"></div>

    <!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>
    <!--NAVBAR-->
    <div id="navbar-container" data-navbar="navbar-logout-<?php echo $_SESSION["user_role"]; ?>"></div>

    <form action="../PHP/submit_article.php" method="POST" class="container">
        <div class="container">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" placeholder="The title of your article" require>

            <label for="abstract">Abstract:</label>
            <input type="text" id="abstract" name="abstract" placeholder="A short recap" require>

            <label for="text">Text:</label>
            <input type="text" id="text" name="text" placeholder="The article" require>

            <label for="images">Images:</label>
            <input type="text" id="images" name="images" placeholder="The URL of your image" require>
        </div>

        <button class="btn">Done</button>
    </form>

    <script src="../JS/navbar.js"></script>
</body>

</html>



    
    <script src="../JS/navbar.js"></script>
</body>

</html>