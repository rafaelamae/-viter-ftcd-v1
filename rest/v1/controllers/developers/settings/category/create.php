<?php

$conn = null;
$conn = checkDbConnection();
$val  = new Category($conn);

$val->cat_is_active   = isset($data['cat_is_active']) ? (int) $data['cat_is_active'] : 1;
$val->cat_name        = trim($data['cat_name']);
$val->cat_description = trim($data['cat_description'] ?? '');
$val->cat_created     = date("Y-m-d H:i:s");
$val->cat_updated     = date("Y-m-d H:i:s");

$query = checkCreate($val);
http_response_code(200);
returnSuccess($val, "Category Create", $query);