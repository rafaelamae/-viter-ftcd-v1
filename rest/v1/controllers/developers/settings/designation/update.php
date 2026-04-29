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
$val  = new Designation($conn);

if (array_key_exists("id", $_GET)) {
    $val->des_aid        = $_GET["id"];
    $val->des_is_active  = isset($data['des_is_active']) ? (int) $data['des_is_active'] : 1;
    $val->des_name       = trim($data['des_name']);
    $val->des_category_id = trim($data['des_category_id']);
    $val->des_updated    = date("Y-m-d H:i:s");

    checkId($val->des_aid);

    $query = checkUpdate($val);
    http_response_code(200);
    returnSuccess($val, "Designation Update", $query);
}

checkEndpoint();
