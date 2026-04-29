<?php

$conn = null;
$conn = checkDbConnection();
$val  = new Designation($conn);

$val->des_is_active  = isset($data['des_is_active']) ? (int) $data['des_is_active'] : 1;
$val->des_name       = trim($data['des_name']);
$val->des_category_id = trim($data['des_category_id']);
$val->des_created    = date("Y-m-d H:i:s");
$val->des_updated    = date("Y-m-d H:i:s");

$query = checkCreate($val);
http_response_code(200);
returnSuccess($val, "Designation Create", $query);
