<?php

$servername = "localhost";
$username = "uiqsamkbka5v1";
$password = "MANDELA@1234";
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

$id='SO567998';
 $stmt = $conn->prepare("SELECT distinct(SalesOrderNumber) FROM GRW_INB_SALES_ORDERS WHERE SalesOrderNumber= ?");
 $stmt->bind_param("s", $id);
 $stmt->execute();
 $result = $stmt->get_result();
 if ($result->num_rows === 0) {
    echo "has rows";
 }else{
    echo "nope";
 }