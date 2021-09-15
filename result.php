<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Google - resultat</title>
    </head>
    <body>
        <h1>Resultats</h1>
        <?php
            $result = $_POST["search"];
            echo "<p>${result}</p>";
        ?>
    </body>
</html>