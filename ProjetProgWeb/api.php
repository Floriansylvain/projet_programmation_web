<?php

require_once("class/dump.php");

if (!isset($_GET['q']) || !isset($_GET['search']) || !isset($_GET['option']) || !isset($_GET['offset'])) {
    print_r(json_encode(array("status" => 400, "message" => "Missing query type or attributes.")));
    exit();
}

$q = $_GET['q'];
$search = filter_var($_GET['search'], FILTER_SANITIZE_ADD_SLASHES);
$option = $_GET['option']; // TODO Ajouter l'option Discipline
$offset = $_GET['offset'];

if (strlen($search) < 3) {
    print_r(json_encode(array(
        "status" => 400,
        "message" => "La recherche doit comporter un minimum de 3 caractères."
    )));
    exit();
}

$json_object = match ($q) {
    "theses" => dump::getTheses($search, $option, $offset),
    "suggestion" => dump::getSuggestions($search, $option),
    "count" => dump::getThesesCount($search, $option),
    "years" => dump::getThesesYears($search, $option),
    "disciplines" => dump::getThesesDisciplines($search, $option),
    "establishments" => dump::getThesesEstablishments($search, $option),
    default => NULL,
};

$json = json_encode(array(
    "status" => 200,
    "message" => "Success",
    "data" => $json_object,
));

echo $json;
