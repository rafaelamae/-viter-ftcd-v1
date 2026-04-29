<?php

require __DIR__ . '/../../../../core/header.php';
require __DIR__ . '/../../../../core/functions.php';
require __DIR__ . '/../../../../models/developers/settings/designation/Designation.php';

$conn = null;
$conn = checkDbConnection();

$val  = new Designation($conn);

$body = file_get_contents("php://input");
$data = json_decode($body, true);

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    if (array_key_exists("start", $_GET)) {
        checkPayload($data);

        $val->start         = $_GET['start'];
        $val->total         = 10;
        $val->des_is_active = $data['filterData'];
        $val->search        = $data['searchValue'];

        checkLimitId($val->start, $val->total);

        $query        = checkReadLimit($val);
        $total_result = checkReadAll($val);
        http_response_code(200);
        checkReadQuery($query, $total_result, $val->total, $val->start);
    }
}

checkEndpoint();
