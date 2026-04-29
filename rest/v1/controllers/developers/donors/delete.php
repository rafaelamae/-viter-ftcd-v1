<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

$conn = null;
$conn = checkDbConnection();
$val  = new Donors($conn);

if (array_key_exists("id", $_GET)) {
    $val->donor_aid = $_GET["id"];
    checkId($val->donor_aid);
    $query = checkDelete($val);
    http_response_code(200);
    returnSuccess($val, "Donors Delete", $query);
}

checkEndpoint();