<?php

$conn = null;
$conn = checkDbConnection();
$val  = new OtherUsers($conn);

$val->otheruser_is_active = isset($data['otheruser_is_active']) ? (int) $data['otheruser_is_active'] : 1;
$val->otheruser_full_name = trim($data['otheruser_full_name']);
$val->otheruser_email     = trim($data['otheruser_email']);
$val->otheruser_role_id   = isset($data['otheruser_role_id']) ? (int) $data['otheruser_role_id'] : 0;
$val->otheruser_created   = date("Y-m-d H:i:s");
$val->otheruser_updated   = date("Y-m-d H:i:s");

isEmailExist($val, $val->otheruser_email);

$query = checkCreate($val);
http_response_code(200);
returnSuccess($val, "Other Users Create", $query);
