<?php

$conn = null;
$conn = checkDbConnection();
$val  = new Children($conn);

$val->children_is_active      = 1; // new children are always active on create
$val->children_full_name      = trim($data['children_full_name']);
$val->children_birth_date     = trim($data['children_birth_date']);
$val->children_my_story       = trim($data['children_my_story']       ?? '');
$val->children_donation_limit = trim($data['children_donation_limit'] ?? '0.00');
$val->children_is_resident    = isset($data['children_is_resident'])  ? (int) $data['children_is_resident'] : 0;
$val->children_created        = date("Y-m-d H:i:s");
$val->children_updated        = date("Y-m-d H:i:s");

$query = checkCreate($val);
http_response_code(200);
returnSuccess($val, "Children Create", $query);