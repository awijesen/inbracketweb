<?php
session_start();
$fromBulk = htmlspecialchars($_POST["currentBulk"] ?? '');
$qty = htmlspecialchars($_POST["replenQty"] ?? '');
$productcode = htmlspecialchars(strtoupper($_POST["productCode"]) ?? '');
$bulkStock = htmlspecialchars($_POST["currentBulkStock"] ?? '');
$user = $_SESSION["UCODE"];
$fromLoc = htmlspecialchars($_POST["fromLoc"] ?? '');
$pface = htmlspecialchars($_POST["pface"] ?? '');
$desc = htmlspecialchars($_POST["descrp"] ?? '');
$whouse = '1';

date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d h:i:s", time());

if (!is_numeric($qty) || $qty === 0 || $qty < 0) {
    echo "Invalid quantity";
    exit;
}

// echo $fromBulk." - ".$qty ." - ".$productcode ." - ". $bulkStock." - ".$user ." - ". $fromLoc." - ".$pface ." - ".$desc."-".$whouse;
// exit;

require('../../dbconnect/db.php');
// echo $fromBulk." - ".$qty." - ".$productcode;

$sql = "UPDATE INB_PICKFACE_STOCK SET PickfaceStock=PickfaceStock + ? WHERE ProductCode=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $qty, $productcode);
$stmt->execute();
$result = $stmt->affected_rows;

if ($result > 0) {
    $sqld = "INSERT INTO INB_STOCK_REPLENISHMENT(ProductCode, ProductDescription, FromLocation, ToLocation, WarehouseId, ReplenQty, ReplenBy, ReplenOn)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtd = $conn->prepare($sqld);
    $stmtd->bind_param("sssssiss", $productcode, $desc, $fromLoc, $pface, $whouse, $qty, $user, $actualtime );
    // $stmtd->execute();
    // $resultd = $stmtd->get_result();
    // if ($resultd === 0) {

    if ($stmtd->execute()) { 
        // echo "updated";
        // exit;
        if ($bulkStock > $qty) {
            $sqlx = "UPDATE INB_BULK_STOCK SET BulkStock=BulkStock - ? WHERE ID=?";
            $stmtx = $conn->prepare($sqlx);
            $stmtx->bind_param("is", $qty, $fromBulk);
            $stmtx->execute();
            $resultx = $stmtx->affected_rows;

            if ($resultx > 0) {
                echo "Success";
            } else{
                echo "An error!";
            }
        } else {
            //delete current bulk location based on its ID
            $sqla = "DELETE FROM INB_BULK_STOCK WHERE ID = ?";
            $stmta = $conn->prepare($sqla);
            $stmta->bind_param("s", $fromBulk);
            $stmta->execute();
            $resulta = $stmta->affected_rows;

            if ($resulta > 0) {
                echo "Success";
                exit;
            } else {
                echo "Error_QA221";
                exit;
            }
        }
    } else {
        echo "Error_322";
        exit;
    }
} else {
    echo "Error_QA222";
    exit;
}
