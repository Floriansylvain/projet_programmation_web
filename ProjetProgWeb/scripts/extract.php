<?php

require_once("../class/these.php");
require_once("../class/dump.php");
require_once("../class/conf.php");
require_once('../class/dotEnv.php');

(new DotEnv(__DIR__ . '/../.env'))->load();

if (($handle = fopen(getenv('FILE'), "r")) !== FALSE) {

    $dbname = getenv('DBNAME');

    $pdo_obj = new conf();
    $pdo = $pdo_obj->getPDO();
    $stmt = $pdo->prepare("TRUNCATE `:dbname`.`theses`");
    $stmt->bindParam(':dbname', $dbname);

    $row = 1;
    while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
        $new_these = these::emptyThese();
        $num = count($data);
        if ($row > 1) {
            for ($c = 0; $c < $num; $c++) {
                $new_these->insertField($data[$c], $c);
            }
            $dump = new dump($new_these);
            try {
                $dump->sendThese($pdo);
            } catch (Exception $e) {
                echo "<br><br>Failed on " . $row . " ( " . $e->getMessage() . " ) :<br>";
            }
        }
        $row++;
    }
    fclose($handle);
    echo "<br><br>CSV file imported into DB. (" . $row . " results)";
}
