<?php
session_start();
$pickDetails = htmlspecialchars($_POST['link'] ?? '');

echo $pickDetails;
$userName = substr($_SESSION["LNAME"], 0, 1);

include(__DIR__.'/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d h:i:s", time());

require('../../dbconnect/db.php');

$sql = "UPDATE INB_COMPLETED_PICKS SET PushedTime=null, PushedStatus=null, PushedBy=null WHERE SalesOrderNumber=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $pickDetails);
$stmt->execute();
$result = $stmt->affected_rows;

if($result > 0) {
    echo "Sent for pick review";
} else {
    echo "Sent Error!";
}
?>