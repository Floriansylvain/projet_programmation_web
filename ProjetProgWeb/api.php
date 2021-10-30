<?php

require_once("class/dump.php");

if (!isset($_GET['q']) || !isset($_GET['author'])) {
    print_r(json_encode(array("status" => 400, "message" => "Missing query type or attributs.")));
    exit();
}

$author_name = $_GET['author'];
$q = $_GET['q'];

$json_object = match ($q) {
    "theses" => dump::getTheseByAuthor($author_name),
    "authors" => dump::getAuthorsByAuthors($author_name),
    default => NULL,
};

$json = json_encode($json_object);
print_r($json);
