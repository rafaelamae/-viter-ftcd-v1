<?php

$conn = null;
$conn = checkDbConnection();
$val  = new Notification($conn);

$val->noti_is_active = isset($data['noti_is_active']) ? (int) $data['noti_is_active'] : 1;
$val->noti_name      = trim($data['noti_name']);
$val->noti_email     = trim($data['noti_email']);
$val->noti_phone     = trim($data['noti_phone'] ?? '');
$val->noti_purpose   = trim($data['noti_purpose']);
$val->noti_created   = date("Y-m-d H:i:s");
$val->noti_updated   = date("Y-m-d H:i:s");

$query = checkCreate($val);
http_response_code(200);
returnSuccess($val, "Notification Create", $query);
