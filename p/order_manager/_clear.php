<?php
session_start();
$tobeDeleted = htmlspecialchars($_POST['sotodel'] ?? '');

include(__DIR__.'/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d h:i:s", time());

require('../../dbconnect/db.php');

$sql = "DELETE FROM GRW_INB_ASSIGNED_ORDERS WHERE SalesOrderNumber=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tobeDeleted);
$stmt->execute();
$result = $stmt->affected_rows;

if($result > 0) {
    echo "deleted";
    exit;
} else {
    echo "error_";
    exit;
}
?>

