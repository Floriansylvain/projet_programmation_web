<?php

require_once("class/dump.php");

$author_name = $_GET['author'];
$these_array = dump::getTheseByAuthor($author_name);
$json = json_encode($these_array);
print_r($json);
