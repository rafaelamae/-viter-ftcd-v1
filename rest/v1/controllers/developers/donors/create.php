<?php

$conn = null;
$conn = checkDbConnection();
$val  = new Donors($conn);

$val->donor_is_active = isset($data['donor_is_active']) ? (int) $data['donor_is_active'] : 0;
$val->donor_full_name = trim($data['donor_full_name']);
$val->donor_email     = trim($data['donor_email']);
$val->donor_contact   = trim($data['donor_contact']  ?? '');
$val->donor_address   = trim($data['donor_address']  ?? '');
$val->donor_city      = trim($data['donor_city']     ?? '');
$val->donor_state     = trim($data['donor_state']    ?? '');
$val->donor_country   = trim($data['donor_country']  ?? '');
$val->donor_zip       = trim($data['donor_zip']      ?? '');
$val->donor_created   = date("Y-m-d H:i:s");
$val->donor_updated   = date("Y-m-d H:i:s");

// Check duplicate email
isEmailExist($val, $val->donor_email);

$query = checkCreate($val);
http_response_code(200);
returnSuccess($val, "Donors Create", $query);