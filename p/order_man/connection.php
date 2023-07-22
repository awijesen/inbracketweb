<?php

$host = "localhost";
$user = "uiqsamkbka5v1";
$password = "MANDELA@1234";
$db = "dbeeoiykwgg853";

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

try {
    $conn = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

} catch (PDOException $e) {
     echo $e->getMessage();
}
