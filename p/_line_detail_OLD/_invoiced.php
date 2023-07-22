<?php
session_start();
$orderNumber = $_POST['link'];

$userName = substr($_SESSION["LNAME"], 0, 1);

include(__DIR__.'/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d h:i:s", time());

require('../../dbconnect/db.php');

$sql = "UPDATE INB_COMPLETED_PICKS SET InvoicedOn='".$actualtime."', InvoiceState='Invoiced', InvoicedBy='".$_SESSION["fname"]. " " .$userName."' WHERE SalesOrderNumber=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $orderNumber);
$stmt->execute();
$result = $stmt->affected_rows;

if($result > 0) {
    echo "Invoiced";
} else {
    echo "Error!";
}
// echo $result;
?>