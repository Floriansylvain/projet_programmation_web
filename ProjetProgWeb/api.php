<?php

require_once("class/dump.php");

if (!isset($_GET['q']) || !isset($_GET['author'])) {
    print_r(json_encode(array("status" => 400, "message" => "Missing query type or attributes.")));
    exit();
}

$author_name = filter_var($_GET['author'], FILTER_SANITIZE_ADD_SLASHES);
$q = $_GET['q'];

if (strlen($author_name) < 3) {
    print_r(json_encode(array("status" => 400, "message" => "Le nom de l'auteur doit comporter un minimum de 3 caractères.")));
    exit();
}

$json_object = match ($q) {
    "theses" => dump::getTheseByAuthor($author_name),
    "authors" => dump::getAuthorsByAuthor($author_name),
    "authorsCount" => dump::getAuthorsCountByAuthor($author_name),
    default => NULL,
};

$json = json_encode(array(
    "status" => 200,
    "message" => "Success", "data" => $json_object
    ),JSON_PRETTY_PRINT);

print_r($json);
