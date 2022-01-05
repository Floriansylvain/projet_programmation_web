<?php

require_once("class/dump.php");

if (!isset($_GET['q']) || !isset($_GET['search']) || !isset($_GET['option'])) {
    print_r(json_encode(array("status" => 400, "message" => "Missing query type or attributes.")));
    exit();
}

$q = $_GET['q'];
$search = filter_var($_GET['search'], FILTER_SANITIZE_ADD_SLASHES);
$option = $_GET['option'];

if (strlen($search) < 3) {
    print_r(json_encode(array(
        "status" => 400,
        "message" => "La recherche doit comporter un minimum de 3 caractères."
    )));
    exit();
}

$json_object = match ($q) {
    "theses" => dump::getTheses($search, $option),
    "suggestion" => dump::getSuggestions($search, $option),
    default => NULL,
};

$json = json_encode(array(
    "status" => 200,
    "message" => "Success",
    "data" => $json_object,
));

echo $json;
