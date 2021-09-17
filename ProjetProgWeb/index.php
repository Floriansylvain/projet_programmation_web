<?php
    $pdo = new PDO('mysql:host=localhost;dbname=projet_prog_web', 'root', 'root');

    // dump_abes_thesesfr.csv

    $row = 1;
    if (($handle = fopen("dump_abes_thesesfr.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
            $num = count($data);
            echo "<p>---------------- " . $row .  " -----------------<br /></p>\n";
            $row++;
            for ($c=0; $c < $num; $c++) {
                if ($data[$c]) {
                    echo $data[$c] . "<br />\n";
                } else {
                    echo "NULL<br />\n";
                }
            }
        }
        fclose($handle);
    }

/*
    $sql = 'SELECT * FROM theses';
    $req = $pdo->query($sql);
    while($row = $req->fetch()) {
        echo "<p>" . $row['author'] . " | " . $row['title'] . "</p>";
    }
    $req->closeCursor();
*/