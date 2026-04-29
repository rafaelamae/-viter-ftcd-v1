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
$val  = new Children($conn);

if (array_key_exists("id", $_GET)) {
    $val->children_aid            = $_GET["id"];
    $val->children_is_active      = isset($data['children_is_active'])  ? (int) $data['children_is_active'] : 0;
    $val->children_full_name      = trim($data['children_full_name']);
    $val->children_birth_date     = trim($data['children_birth_date']);
    $val->children_my_story       = trim($data['children_my_story']       ?? '');
    $val->children_donation_limit = trim($data['children_donation_limit'] ?? '0.00');
    $val->children_is_resident    = isset($data['children_is_resident'])  ? (int) $data['children_is_resident'] : 0;
    $val->children_updated        = date("Y-m-d H:i:s");

    checkId($val->children_aid);

    $query = checkUpdate($val);
    http_response_code(200);
    returnSuccess($val, "Children Update", $query);
}

checkEndpoint();