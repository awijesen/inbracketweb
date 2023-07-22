<?php
session_start();
$PickerVal = $_POST['PickerVal'];
$OrderVal = $_POST['OrderVal'];

include(__DIR__.'/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d h:i:s", time());

require('../../dbconnect/db.php');

$sql = "UPDATE GRW_INB_ASSIGNED_ORDERS SET Picker=? WHERE SalesOrderNumber=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $PickerVal, $OrderVal);
$stmt->execute();
$result = $stmt->affected_rows;

echo $result;
?>

