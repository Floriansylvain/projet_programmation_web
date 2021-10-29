<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="app.js"></script>
        <link rel="stylesheet" href="stylesheet.css">
        <title>Document</title>
    </head>
    <body>
        <?php
            include("navbar.php");
            if (isset($_POST['author'])) {
                if (strlen($_POST['author']) < 3) {
                    echo "<p class='error'>Veuillez entrer 3 caractères minimum.</p>";
                } else {
                    echo "<script>requestToApi('" . $_POST['author'] . "')</script>";
                }
            }
        ?>
        <div id="results"></div>
    </body>
</html>
