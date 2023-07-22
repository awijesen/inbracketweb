<?php
session_start();
$tobeDeleted = $_POST['link'];
$pCode = $_POST['pCode'];
$pQty = $_POST['pQty'];

include(__DIR__.'/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d h:i:s", time());

require('../../dbconnect/db.php');

$sql = "DELETE FROM INB_ORDER_PICKS WHERE ID=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tobeDeleted);
$stmt->execute();
$result = $stmt->affected_rows;

if($result > 0) {
    // echo "yes";
    exit;
    $sqla = "UPDATE INB_PICKFACE_STOCK SET PickfaceStock=PickfaceStock + ? WHERE ProductCode=?";
    $stmta = $conn->prepare($sqla);
    $stmta->bind_param("is", $pQty, $pCode);
    $stmta->execute();

    $resulta = $stmta->affected_rows;

    echo $resulta;
} else {
    echo "Error";
}
?>

