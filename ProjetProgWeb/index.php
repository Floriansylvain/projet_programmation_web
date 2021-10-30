<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="stylesheet.css">
        <title>Document</title>
    </head>
    <body>
        <?php
            include("navbar.php");
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

        <script src="app.js"></script>

        <?php
        if (isset($_GET['author'])) {
            if (strlen($_GET['author']) < 3) {
                echo "<p class='error'>Veuillez entrer 3 caractères minimum.</p>";
            } else {
                echo "<script>requestToApi('" . filter_var($_GET['author'], FILTER_SANITIZE_ADD_SLASHES) . "')</script>";
            }
        } else {
            echo "<script>document.getElementsByClassName('loader')[0].style.display = \"none\"</script>";
        }
        ?>

    </body>
</html>
