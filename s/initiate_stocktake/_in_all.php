<?php
include(__DIR__ . '/../../dbconnect/db.php');

$stmtz = $conn->prepare("SELECT * FROM INB_STOCKTAKE_SNAPSHOT");
// $stmtz->bind_param("s", $id);
$stmtz->execute();
$resultz = $stmtz->get_result();
if ($resultz->num_rows === 0) {
    //add
    $entry = "STK-". date("Y-m-d") ."-". bin2hex(openssl_random_pseudo_bytes(5));

    $stmtzn = $conn->prepare("INSERT INTO INB_STOCKTAKE_SNAPSHOT
                                SELECT 
                                ID,
                                ProductCode, 
                                CustomFieldOne, 
                                CustomFieldTwo, 
                                ProductDescription, 
                                Barcode, 
                                ERPStock, 
                                LastCost, 
                                '".$entry."'
                                FROM INB_PRODUCT_MASTER");
    $stmtzn->execute();

    $resultzn = $stmtzn->get_result();
    if ($resultzn->num_rows === 0) {
        echo "Assign Failed!";
    } else {
        echo "Success!";
        // $success_count++;
    }
} else {
    $sql = "DELETE FROM INB_STOCKTAKE_SNAPSHOT";
    $stmt = $conn->prepare($sql);
    // $stmt->bind_param("s", $tobeDeleted);
    $stmt->execute();
    $result = $stmt->affected_rows;

    if($result > 0) {
        $entry = "STK-". date("Y-m-d") . bin2hex(openssl_random_pseudo_bytes(5));
        $stmtzx = $conn->prepare("INSERT INTO INB_STOCKTAKE_SNAPSHOT
                                SELECT
                                ID, 
                                ProductCode, 
                                CustomFieldOne, 
                                CustomFieldTwo, 
                                ProductDescription, 
                                Barcode, 
                                ERPStock, 
                                LastCost, 
                                '".$entry."'
                                FROM INB_PRODUCT_MASTER");
    $stmtzx->execute();

    $resultzx = $stmtzx->get_result();
    if ($resultzx->num_rows === 0) {
        echo "Assign Failed!";
    } else {
        echo "Success!";
        // $success_count++;
    }
    } else {
        echo "error_";
        exit;
    }
}