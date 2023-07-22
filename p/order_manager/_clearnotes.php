<?php
session_start();
$tobeDeleted = htmlspecialchars($_POST['so'] ?? '');

include(__DIR__.'/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d h:i:s", time());

require('../../dbconnect/db.php');

$sql = "UPDATE GRW_INB_SALES_ORDERS SET OrderNotes=null WHERE SalesOrderNumber=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tobeDeleted);
$stmt->execute();
$result = $stmt->affected_rows;

if($result > 0) {
    echo "updated";
    exit;
} else {
    // echo "error_";
    exit;
}
?>

