<?php
include(__DIR__ . '/../../dbconnect/db.php');

$stmtzn = $conn->prepare("INSERT INTO INB_PICKFACE_STOCK (ProductCode, PickfaceStock, WarehouseId, Pickface)
    SELECT ProductCode, StocktakeCount, WarehouseId, CountLocation 
    FROM INB_STOCKTAKE_MASTER 
    WHERE LocationClass='Pick Face' 
    GROUP BY ProductCode");

$stmtzn->execute();

$resultzn = $stmtzn->get_result();
if ($resultzn->num_rows === 0) {
    echo "Action failed. Close this window and try again";
} else {
    $stmtzx = $conn->prepare("INSERT INTO INB_BULK_STOCK (ProductCode, BulkStock, WarehouseId, BulkLocation)
        SELECT 
        ProductCode,
        sum(StocktakeCount),
        WarehouseId,
        CountLocation
        FROM INB_STOCKTAKE_MASTER 
        WHERE LocationClass='Bulk'
        GROUP BY CountLocation, ProductCode
        ORDER BY ProductCode DESC");

    $stmtzx->execute();

    $resultzx = $stmtzx->get_result();
    if ($resultzx->num_rows === 0) {
        echo "Action failed. Close this window and try again.";
    } else {
        echo "Success!";
    }
}
