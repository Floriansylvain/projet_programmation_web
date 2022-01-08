<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="stylesheet.css">
        <title>Theses FR</title>
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

        <div class="page-nav">
            <p onclick="browseResults(currentPage - 1)">&#60;-</p>
            <div></div>
            <p onclick="browseResults(currentPage + 1)">-&#62;</p>
        </div>

        <div id="results">
            <h1 style="color:#CFCFCF;text-align: center">Bienvenue sur theses.fr</h1>
        </div>

        <div id="scrollToTop" class="scroll-to-top">
            <svg class="scroll-to-top" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path class="scroll-to-top" d="M23.677 18.52c.914 1.523-.183 3.472-1.967 3.472h-19.414c-1.784 0-2.881-1.949-1.967-3.472l9.709-16.18c.891-1.483 3.041-1.48 3.93 0l9.709 16.18z"/>
            </svg>
        </div>

        <div id="error">
            <div id="error-message"></div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="error-button">
                <path d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z"/>
            </svg>
        </div>

        <!-- TODO Footer avec lien vers depot github -->

        <script src="app.js"></script>

    </body>
</html>
