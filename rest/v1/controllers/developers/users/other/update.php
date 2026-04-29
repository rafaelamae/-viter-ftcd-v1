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
$val  = new OtherUsers($conn);

if (array_key_exists("id", $_GET)) {
    $val->otheruser_aid       = $_GET["id"];
    $val->otheruser_is_active = isset($data['otheruser_is_active']) ? (int) $data['otheruser_is_active'] : 1;
    $val->otheruser_full_name = trim($data['otheruser_full_name']);
    $val->otheruser_email     = trim($data['otheruser_email']);
    $val->otheruser_role_id   = isset($data['otheruser_role_id']) ? (int) $data['otheruser_role_id'] : 0;
    $val->otheruser_updated   = date("Y-m-d H:i:s");

    $otheruser_email_old = $data['otheruser_email_old'];

    checkId($val->otheruser_aid);
    compareEmail($val, $otheruser_email_old, $val->otheruser_email);

    $query = checkUpdate($val);
    http_response_code(200);
    returnSuccess($val, "Other Users Update", $query);
}

checkEndpoint();
