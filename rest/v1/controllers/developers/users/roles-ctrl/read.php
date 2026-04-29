<?php

$conn = null;
$conn = checkDbConnection();
$val  = new Roles($conn);

if (empty($_GET)) {
    $query = $val->readAllActive();
    checkQuery($query, "Empty records. (read All Active)");
    http_response_code(200);
    getQueriedData($query);
}

checkEndpoint();
