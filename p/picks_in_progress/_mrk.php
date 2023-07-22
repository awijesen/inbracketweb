<?php
session_start();
$order_ = htmlspecialchars($_POST['otom'] ?? '');
$urg_ = htmlspecialchars($_POST['urg'] ?? '');

// $userName = substr($_SESSION["LNAME"], 0, 1);

include(__DIR__.'/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d h:i:s", time());

require('../../dbconnect/db.php');

$sql = "UPDATE GRW_INB_ASSIGNED_ORDERS SET CustomFlag=? WHERE SalesOrderNumber=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $urg_, $order_);
$stmt->execute();
$result = $stmt->affected_rows;

if($result > 0) {
    echo "mkd";
} else {
    echo "umkd";
}
?>