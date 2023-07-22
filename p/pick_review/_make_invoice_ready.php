<?php
session_start();
$pickDetails = $_POST['link'];

echo $pickDetails;
$userName = substr($_SESSION["LNAME"], 0, 1);

include(__DIR__.'/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d h:i:s", time());

require('../../dbconnect/db.php');

$sql = "UPDATE INB_COMPLETED_PICKS SET PushedTime='".$actualtime."', PushedStatus='Pushed', PushedBy='".$_SESSION["fname"]. " " .$userName."' WHERE SalesOrderNumber=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $pickDetails);
$stmt->execute();
$result = $stmt->affected_rows;

echo $result;
?>