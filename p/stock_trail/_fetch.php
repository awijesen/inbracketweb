<?php
require('../../dbconnect/db.php');

$CODE =  htmlspecialchars($_POST['autoSizingInputProduct'] ?? '');

if($CODE == '') {
    echo "Product code required";
} else {
$sql =  "SELECT A.So as 'SO', A.Code as 'Code', A.Qty as 'Qty', A.Date as 'Date', A.User as 'User', A.channel as 'channel' FROM(
    SELECT 
    SalesOrderNumber as 'So',
    ProductCode as 'Code',
    PickedQty * -1 as 'Qty',
    PickedOn as 'Date',
    PickedBy as 'User',
    'Pick Task' as 'channel'
    FROM INB_COMPLETED_PICKS wHERE ProductCode='".$CODE."' and DATE_FORMAT(PickedOn, '%d-%m-%Y') > '01-12-2022'
    UNION ALL
    SELECT 
    SalesOrderNumber as 'SO',
    ProductCode as 'Code',
    PickedQty * -1 as 'Qty',
    PickedOn as 'Date',
    PickedBy as 'User',
    'Pick Task' as 'channel'
    FROM INB_ORDER_PICKS WHERE ProductCode='".$CODE."' and DATE_FORMAT(PickedOn, '%d-%m-%Y') > '01-12-2022'
    UNION ALL
    SELECT 
    PONumber as 'SO',
    ProductCode as 'Code',
    ReceivedQuantity as 'Qty',
    ReceivedTimeStamp as 'Date',
    Receiver as 'User',
    'Receipt Task' as 'channel'
    FROM INB_PURCHASE_RECEIPTS WHERE ProductCode='".$CODE."' and DATE_FORMAT(ReceivedTimeStamp, '%d-%m-%Y') > '01-12-2022'
    UNION ALL
    SELECT
    CASE
    WHEN ChangeReason = 'CY' THEN 'Cyclecount stock correction'
    WHEN ChangeReason = 'DM' THEN 'Damaged stock'
    WHEN ChangeReason = 'EX' THEN 'Expired stock'
    WHEN ChangeReason = 'DN' THEN 'Donation'
    WHEN ChangeReason = 'WR' THEN 'Write off'
    WHEN ChangeReason = 'VC' THEN 'Vendor claim'
    WHEN ChangeReason = 'ST' THEN 'Staff use'
    ELSE ''
    END as 'SO',
    ProductCode as 'Code',
    ChangedQty as 'Qty',
    ChangedOn as 'Date',
    ChangedBy as 'User',
    'Stock Adjustment' as 'channel'
    FROM INB_STOCK_CORRECTION_TRAIL WHERE ProductCode='".$CODE."' and DATE_FORMAT(ChangedOn, '%d-%m-%Y') > '01-12-2022'
    ) A ORDER BY Date DESC";

// $sql = "SELECT distinct(OrderCustomer), OrderValue as 'Val', Reference as 'Ref' FROM GRW_INB_SALES_ORDERS WHERE SalesOrderNumber=? group by SalesOrderNumber";
$stmt = $conn->prepare($sql);
// $stmt->bind_param("s", $orderToFetch);
$stmt->execute();
$result = $stmt->get_result();
$num_rows = mysqli_num_rows($result);
if($num_rows > 1) {
?>

<table class="table table-sm table-striped table-hover fs--1 mt-4" style="font-family: var(--falcon-font-sans-serif)">
    <thead>
        <tr>
            <th scope="col">Transaction&nbsp;Type</th>
            <th scope="col">Qty&nbsp;Change</th>
            <th scope="col">User</th>
            <th scope="col">Time&nbsp;Stamp</th>
            <th scope="col">Change&nbsp;Reference</th>
        </tr>
    </thead><tbody>

    <?php
    while ($row = $result->fetch_assoc()) {

        $dateToBeInserted = date('d-m-Y h:i a', strtotime($row['Date']));

        echo "
                <tr>
                <td class='text-nowrap'>" . $row["channel"] . "</td>
                <td class='text-nowrap text-center'>" . $row["Qty"] . "</td>
                <td class='text-nowrap'>" . $row["User"] . "</td>
                <td class='text-nowrap'>" . $dateToBeInserted . "</td>
                <td class='text-nowrap'>" . $row["SO"] . "</td>
                </tr>
                ";
    }
 ?>
</tbody></table> <?php } else {
    echo "Invalid product code";
    exit;
}
}
