<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
        <title>Google</title>
    </head>
    <body class="vw-100 vh-100">

        <div class="d-flex flex-column justify-content-center align-items-center h-75">

            <img class="img-fluid w-25 my-3" src="assets/google_logo.png" />

            <form class="d-flex flex-column justify-content-center align-items-center w-50" action="result.php" method="POST">
                <svg></svg>
                <input id="search-input" class="w-75 p-2 px-3 border border-secondary rounded-pill" type="text" name="search" />
                <div class="m-3">
                    <button class="btn btn-light rounded p-2 px-3 m-2">Recherche Google</button>
                    <button class="btn btn-light rounded p-2 px-3 m-2">J'ai de la chance</button>
                </div>
            </form>

        </div>

    </body>
</html>