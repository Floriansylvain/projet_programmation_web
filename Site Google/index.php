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
                <div id="search-input" class="d-flex w-75 p-2 px-3 border border-light rounded-pill">
                    <img src="assets/search.svg"/>
                    <input class="w-100 border-0 px-3" type="text" name="search"/>
                </div>
                <div class="m-3">
                    <button class="btn btn-light rounded p-2 px-3 m-2 text-secondary">Recherche Google</button>
                    <button class="btn btn-light rounded p-2 px-3 m-2 text-secondary">J'ai de la chance</button>
                </div>
            </form>

        </div>

        <div class="container">
          <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <p class="col-md-4 mb-0 text-muted"></p>

            <ul class="nav col-md-4 justify-content-end">
              <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Info consommateurs</a></li>
              <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Confidentialité</a></li>
              <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Conditions</a></li>
              <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Paramètres</a></li>
            </ul>
          </footer>
        </div>

    </body>
</html>