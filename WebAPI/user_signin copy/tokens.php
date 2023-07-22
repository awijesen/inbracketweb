<?php

$payload = [
    "username" => $user["UserId"],
    "UserCode" => $user["UserCode"],
    "tenent" => $user["tenent_id"],
    "tenent_pfx" => $user["tenent_prefix"],
    "WhId" => $user["AssignedWarehouse"],
    "uRole" => $user["UserRole"],
    "exp" => time() + 1200
];


$access_token = $codec->encode($payload);

$refresh_token_expiry = time() + 432000;

$refresh_token = $codec->encode([
    "sub" => $user["UserId"],
    "exp" => $refresh_token_expiry
]);
 
$servername = "localhost";
$username = "uiqsamkbka5v1";
$password = "G&RWills90";
$dbname = "dbeeoiykwgg853";

$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "UPDATE INB_USERMASTER set LoginChannelMobile='1' WHERE UserCode=? and tenent_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $user["UserCode"], $user["tenent_id"]);

$status = $stmt->execute();
// if ($status) {}

echo json_encode([
    "access_token" => $access_token,
    "refresh_token" => $refresh_token
]);