<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require __DIR__ . '/../../../core/header.php';
require __DIR__ . '/../../../core/functions.php';
require __DIR__ . '/../../../models/developers/children/Children.php';

$conn = null;
$conn = checkDBConnection();

$val  = new Children($conn);

$body = file_get_contents("php://input");
$data = json_decode($body, true);

if (array_key_exists('id', $_GET)) {
    checkPayload($data);
    $val->children_aid       = $_GET['id'];
    $val->children_is_active = trim($data['isActive']);
    $val->children_updated   = date('Y-m-d H:i:s');

    checkId($val->children_aid);

    $query = checkActive($val);
    http_response_code(200);
    returnSuccess($val, 'children active', $query);
}

checkEndpoint();