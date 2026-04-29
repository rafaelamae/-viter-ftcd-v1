<?php

$conn = null;
$conn = checkDbConnection();
$val  = new Roles($conn);

$val->role_is_active   = isset($data['role_is_active']) ? (int) $data['role_is_active'] : 1;
$val->role_name        = trim($data['role_name']);
$val->role_description = trim($data['role_description'] ?? '');
$val->role_created     = date("Y-m-d H:i:s");
$val->role_updated     = date("Y-m-d H:i:s");

$query = checkCreate($val);
http_response_code(200);
returnSuccess($val, "Roles Create", $query);
