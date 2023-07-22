<?php
session_start();

date_default_timezone_set('Australia/Darwin');
$actualtime = date("Y-m-d h:i:s", time());

$change = htmlspecialchars($_POST['change'] ?? '');
$code = htmlspecialchars($_POST['code'] ?? '');
$reason = htmlspecialchars($_POST['reasoncode'] ?? '');
$price = htmlspecialchars($_POST['pricep'] ?? '0');
$user = $_SESSION['UCODE'];
$notes = htmlspecialchars($_POST['notes']);

if ($change == '' || $code == '' || $reason == '' || $notes == '') {
    echo "Missing required details. Please check again";
} else {
    require(__DIR__ . '../../../dbconnect/db.php');

    $sql = "UPDATE INB_PICKFACE_STOCK set PickfaceStock=PickfaceStock + (?) WHERE ProductCode=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        'is',
        $change,
        $code
    );

    $status = $stmt->execute();
    if ($status) {

        $stmtx = $conn->prepare("INSERT INTO INB_STOCK_CORRECTION_TRAIL (
            ProductCode,
            ChangedQty,
            ChangedOn,
            ChangedBy,
            ChangeReason,
            UnitPrice,
            ChangeNotes) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmtx->bind_param('sisssss', strtoupper($code), $change, $actualtime, $user, $reason, $price, $notes);
        $stmtx->execute();

        $resultx = $stmtx->get_result();
        if ($resultx->num_rows === 0) {
            echo "Update failed";
        } else {
            echo "<p style='color:green' class='fs--1'>Stock correction successfull</p>";
        }
    } else {
        echo "Error - UABG230023";
    }
}
