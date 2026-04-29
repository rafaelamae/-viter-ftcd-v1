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
$val  = new SystemUsers($conn);

if (array_key_exists("id", $_GET)) {
    $val->sysuser_aid       = $_GET["id"];
    $val->sysuser_is_active = isset($data['sysuser_is_active']) ? (int) $data['sysuser_is_active'] : 1;
    $val->sysuser_full_name = trim($data['sysuser_full_name']);
    $val->sysuser_email     = trim($data['sysuser_email']);
    $val->sysuser_role_id   = isset($data['sysuser_role_id']) ? (int) $data['sysuser_role_id'] : 0;
    $val->sysuser_updated   = date("Y-m-d H:i:s");

    $sysuser_email_old = $data['sysuser_email_old'];

    checkId($val->sysuser_aid);
    compareEmail($val, $sysuser_email_old, $val->sysuser_email);

    $query = checkUpdate($val);
    http_response_code(200);
    returnSuccess($val, "System Users Update", $query);
}

checkEndpoint();
