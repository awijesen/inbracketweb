<?php
session_start();
$tobeDeleted = $_POST['link'];
$pCode = $_POST['pCode'];
$pQty = $_POST['pQty'];

include(__DIR__.'/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d h:i:s", time());

require('../../dbconnect/db.php');

$sql = "INSERT INTO GRW_INB_ASSIGNED_ORDERS (
    UserId,
    SalesOrderId,
    SalesOrderNumber, 
    ProductCode, 
    ProductId,
    ProductDescription,
    OrderQuantity,
    Picker,
    AssignedBy,
    AssignedOn,
    OrderCustomer,
    Reference,
    UOM,
    Notes)
    SELECT 
    '' as 'UserId',
    ass.SalesOrderId,
    ass.SalesOrderNumber, 
    ass.ProductCode, 
    ass.ProductId,
    (SELECT distinct(pm.ProductDescription) FROM INB_PRODUCT_MASTER pm WHERE pm.ProductCode=ass.ProductCode) as 'ProductDescription',
    ass.OrderQuantity,
    ass.PickedBy,
    ass.AssignedBy,
    ass.AssignedOn,
    ass.OrderCustomer,
    ass.Reference,
    ass.UOM,
    ass.Notes
    FROM INB_COMPLETED_PICKS ass
    WHERE SalesOrderNumber=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tobeDeleted);
    $stmt->execute();
    $result = $stmt->affected_rows;

if($result > 0) {
    
$sql2 = "INSERT INTO INB_ORDER_PICKS(
    SalesOrderId,
    SalesOrderNumber, 
    ProductCode, 
    ProductId,
    PickedBy,
    PickedQty,
    PickedOn,
    PickStatus,
    ReasonCode)
    SELECT 
    ass.SalesOrderId,
    ass.SalesOrderNumber, 
    ass.ProductCode, 
    ass.ProductId,
    ass.PickedBy,
    ass.PickedQty,
    ass.PickedOn,
    'InProgress',
    ass.ReasonCode
    FROM INB_COMPLETED_PICKS ass
    where SalesOrderNumber=?;";

    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("s", $tobeDeleted);
    $stmt2->execute();
    $result2 = $stmt2->affected_rows;

    if($result2 > 0) {
        $sql3 = "DELETE FROM INB_COMPLETED_PICKS WHERE SalesOrderNumber=?;";
        $stmt3 = $conn->prepare($sql3);
        $stmt3->bind_param("s", $tobeDeleted);
        $stmt3->execute();
        $result3 = $stmt3->affected_rows;
        
        if($result3 > 0) {
            echo "Completed";
        } else {
            echo "Error-45H7KK";
        }
        
    } else {
        echo "Error-47YHGKL";
        }
} else {
    echo "Error";
}
?>

