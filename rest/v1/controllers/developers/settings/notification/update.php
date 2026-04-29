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
$val  = new Notification($conn);

if (array_key_exists("id", $_GET)) {
    $val->noti_aid       = $_GET["id"];
    $val->noti_is_active = isset($data['noti_is_active']) ? (int) $data['noti_is_active'] : 1;
    $val->noti_name      = trim($data['noti_name']);
    $val->noti_email     = trim($data['noti_email']);
    $val->noti_phone     = trim($data['noti_phone'] ?? '');
    $val->noti_purpose   = trim($data['noti_purpose']);
    $val->noti_updated   = date("Y-m-d H:i:s");

    checkId($val->noti_aid);

    $query = checkUpdate($val);
    http_response_code(200);
    returnSuccess($val, "Notification Update", $query);
}

checkEndpoint();
