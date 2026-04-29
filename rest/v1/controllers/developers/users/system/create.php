<?php

$conn = null;
$conn = checkDbConnection();
$val  = new SystemUsers($conn);

$val->sysuser_is_active = isset($data['sysuser_is_active']) ? (int) $data['sysuser_is_active'] : 1;
$val->sysuser_full_name = trim($data['sysuser_full_name']);
$val->sysuser_email     = trim($data['sysuser_email']);
$val->sysuser_role_id   = isset($data['sysuser_role_id']) ? (int) $data['sysuser_role_id'] : 0;
$val->sysuser_created   = date("Y-m-d H:i:s");
$val->sysuser_updated   = date("Y-m-d H:i:s");

isEmailExist($val, $val->sysuser_email);

$query = checkCreate($val);
http_response_code(200);
returnSuccess($val, "System Users Create", $query);
