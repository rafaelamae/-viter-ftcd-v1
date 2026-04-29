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
$val  = new Category($conn);

if (array_key_exists("id", $_GET)) {
    $val->cat_aid         = $_GET["id"];
    $val->cat_is_active   = isset($data['cat_is_active']) ? (int) $data['cat_is_active'] : 1;
    $val->cat_name        = trim($data['cat_name']);
    $val->cat_description = trim($data['cat_description'] ?? '');
    $val->cat_updated     = date("Y-m-d H:i:s");

    checkId($val->cat_aid);

    $query = checkUpdate($val);
    http_response_code(200);
    returnSuccess($val, "Category Update", $query);
}

checkEndpoint();