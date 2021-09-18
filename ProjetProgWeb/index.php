<?php

require_once("conf.php");
require_once("class/these.php");
require_once("class/dump.php");

$these = new these("Florian",
    "967125",
    "Ma thèse très sympa",
    "Didier Deschamps",
    "Deschamps Didier",
    "8516243",
    "IUT Marne la vallée",
    "128675",
    "Informatique",
    "passée",
    "2001-1-3",
    "2000-12-24",
    "en",
    "2146795",
    false,
    "2000-1-1",
    "2000-1-1"
);

$dump = new dump($these);
$dump->sendThese();

/*
$row = 1;
if (($handle = fopen("scripts/dump_abes_thesesfr.csv", "r")) !== FALSE) {
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
}*/


/*
    $sql = 'SELECT * FROM theses';
    $req = $pdo->query($sql);
    while($row = $req->fetch()) {
        echo "<p>" . $row['author'] . " | " . $row['title'] . "</p>";
    }
    $req->closeCursor();
*/
