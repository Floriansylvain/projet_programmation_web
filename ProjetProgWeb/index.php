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

        <!-- La petite animation de chargement provient de :
             https://freefrontend.com/css-spinners/
             Réalisée par Jon Marron -->
        <div class="loader">
            <svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                <circle class="load one" cx="60" cy="60" r="40" />
                <circle class="load two" cx="60" cy="60" r="40" />
                <circle class="load three" cx="60" cy="60" r="40" />
                <g>
                    <circle class="point one" cx="45" cy="70" r="5" />
                    <circle class="point two" cx="60" cy="70" r="5" />
                    <circle class="point three" cx="75" cy="70" r="5" />
                </g>
            </svg>
        </div>

        <div id="results-count"></div>
        <div id="results"></div>
    </body>
</html>
