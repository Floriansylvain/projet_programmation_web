<?php

require_once("../class/these.php");
require_once("../class/dump.php");
require_once("../class/conf.php");
require_once('../class/dotEnv.php');

(new DotEnv(__DIR__ . '/../.env'))->load();

if (($handle = fopen("2021-09-15-theses.csv", "r")) !== FALSE) {

    $pdo_obj = new conf();
    $pdo = $pdo_obj->getPDO();
    $stmt = $pdo->query("TRUNCATE `" . getenv('DBNAME') ."`.`theses`");

    $row = 1;
    while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
        $new_these = these::emptyThese();
        $num = count($data);
        if ($row > 1) {
            for ($c = 0 ; $c < $num ; $c++) {
                $new_these->insertField($data[$c], $c);
            }
            $dump = new dump($new_these);
            try {
                $dump->sendThese($pdo);
            } catch (Exception $e) {
                echo "<br><br>Failed on " . $row ." ( " . $e->getMessage() . " ) :<br>";
            }
        } $row++;
    }
    fclose($handle);
    echo "<br><br>CSV file imported into DB. (" . $row . " results)";
}
