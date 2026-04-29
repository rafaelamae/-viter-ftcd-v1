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
$val  = new Roles($conn);

if (array_key_exists("id", $_GET)) {
    $val->role_aid         = $_GET["id"];
    $val->role_is_active   = isset($data['role_is_active']) ? (int) $data['role_is_active'] : 1;
    $val->role_name        = trim($data['role_name']);
    $val->role_description = trim($data['role_description'] ?? '');
    $val->role_updated     = date("Y-m-d H:i:s");

    checkId($val->role_aid);

    $query = checkUpdate($val);
    http_response_code(200);
    returnSuccess($val, "Roles Update", $query);
}

checkEndpoint();
