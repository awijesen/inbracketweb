<?php

$servername = "localhost";
$username = "uiqsamkbka5v1";
$password = "G&RWills90";
$dbname = "dbeeoiykwgg853";


// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "INB";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}