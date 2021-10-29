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

            if (!isset($_POST['author'])) {
                exit();
            }

            require_once("class/dump.php");

            $author_name = $_POST['author'];

            $these_array = dump::getTheseByAuthor($author_name);

            $json = json_encode($these_array, JSON_PRETTY_PRINT);

            echo '<pre>';
            var_dump($json);
            echo '</pre>';

        ?>
    </body>
</html>
