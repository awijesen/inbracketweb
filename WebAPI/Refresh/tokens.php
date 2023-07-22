<?php

$payload = [
    "username" => $user["UserId"],
    "password" => $user["pw"],
    "UserCode" => $user["UserCode"],
    "tenent" => $user["tenent_id"],
    "tenent_pfx" => $user["tenent_prefix"],
    "WhId" => $user["AssignedWarehouse"],
    "exp" => time() + 300
];


$access_token = $codec->encode($payload);

$refresh_token_expiry = time() + 432000;

$refresh_token = $codec->encode([
    "sub" => $user["UserId"],
    "exp" => $refresh_token_expiry
]);



echo json_encode([
    "access_token" => $access_token,
    "refresh_token" => $refresh_token
]);