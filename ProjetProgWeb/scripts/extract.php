<?php

require_once("../conf.php");
require_once("../class/these.php");
require_once("../class/dump.php");


if (($handle = fopen("dump_abes_thesesfr.csv", "r")) !== FALSE) {
    $row = 1;
    $new_these = these::emptyThese();
    while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
        $num = count($data);
        if ($row > 1) {
            for ($c = 0 ; $c < $num ; $c++) {
                $new_these->insertField($data[$c], $c);
            }
            $dump = new dump($new_these);
            $dump->sendThese();
        } $row++;
    }
    fclose($handle);
    echo "CSV file imported into DB.";
}
