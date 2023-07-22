<?php
session_start();
$tobeDeleted = $_POST['link'];
$pCode = $_POST['pCode'];
$pQty = (int)$_POST['pQty'];
$user_ = $_SESSION['UCODE'];
$order = $_POST['sorder'];
$price = $_POST['price'];
$reason = "LR";
$warehouse = '1';

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
    // exit;
    $sqla = "UPDATE INB_PICKFACE_STOCK SET PickfaceStock=PickfaceStock + ? WHERE ProductCode=?";
    $stmta = $conn->prepare($sqla);
    $stmta->bind_param("is", $pQty, $pCode);
    $stmta->execute();

    $resulta = $stmta->affected_rows;

    if($resulta > 0) {
        $stmtx = $conn->prepare("INSERT INTO INB_STOCK_CORRECTION_TRAIL (
            ProductCode,
            ChangedQty,
            ChangedOn,
            ChangedBy,
            ChangeReason,
            UnitPrice,
            ChangeNotes) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmtx->bind_param('sisssss', strtoupper($pCode), $pQty, $actualtime, $user_, $reason, $price, $order);
        $stmtx->execute();

        $resultx = $stmtx->get_result();
        if ($resultx->num_rows === 0) {
            echo "Update failed";
        } else {
            echo "<p style='color:green' class='fs--1'>Stock correction successfull</p>";
        }
    }
    echo $resulta;
} else {
    echo "Error";
}
?>

