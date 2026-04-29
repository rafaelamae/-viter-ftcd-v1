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
    $val->donor_aid       = $_GET["id"];
    $val->donor_is_active = isset($data['donor_is_active']) ? (int) $data['donor_is_active'] : 0;
    $val->donor_full_name = trim($data['donor_full_name']);
    $val->donor_email     = trim($data['donor_email']);
    $val->donor_contact   = trim($data['donor_contact']  ?? '');
    $val->donor_address   = trim($data['donor_address']  ?? '');
    $val->donor_city      = trim($data['donor_city']     ?? '');
    $val->donor_state     = trim($data['donor_state']    ?? '');
    $val->donor_country   = trim($data['donor_country']  ?? '');
    $val->donor_zip       = trim($data['donor_zip']      ?? '');
    $val->donor_updated   = date("Y-m-d H:i:s");

    $donor_email_old = $data['donor_email_old'];

    checkId($val->donor_aid);
    compareEmail($val, $donor_email_old, $val->donor_email);

    $query = checkUpdate($val);
    http_response_code(200);
    returnSuccess($val, "Donors Update", $query);
}

checkEndpoint();