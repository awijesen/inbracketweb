<?php
require('../../dbconnect/db.php');

$CODE =  htmlspecialchars($_POST['autoSizingInputProduct'] ?? '');

if($CODE == '') {
    echo "Product code required";
} else {
$sql =  "SELECT 
ProductCode as 'loc',
ProductDescription as 'class',
Pricing_Tow as 'stock' 
FROM INB_PRODUCT_MASTER
WHERE ProductCode='".$CODE."'
GROUP BY ProductCode
UNION ALL
SELECT 'Total' as 'loc', '' as 'class', SUM(stock) as 'stock' from(
                SELECT
                Pickface as 'loc',
                'Pickface' as 'class',
                PickfaceStock as 'stock' 
                FROM INB_PICKFACE_STOCK 
                WHERE ProductCode='".$CODE."'
                UNION ALL
                SELECT 
                BulkLocation as 'loc',
                'Bulk' as 'class',
                BulkStock as 'stock'
                FROM INB_BULK_STOCK 
                WHERE ProductCode='".$CODE."' 
                ORDER BY class DESC) as tbl
                union all
                SELECT
                Pickface as 'loc',
                'Pickface' as 'class',
                PickfaceStock as 'stock' 
                FROM INB_PICKFACE_STOCK 
                WHERE ProductCode='".$CODE."'
                UNION ALL
                SELECT 
                BulkLocation as 'loc',
                'Bulk' as 'class',
                BulkStock as 'stock'
                FROM INB_BULK_STOCK 
                WHERE ProductCode='".$CODE."'";

// $sql = "SELECT distinct(OrderCustomer), OrderValue as 'Val', Reference as 'Ref' FROM GRW_INB_SALES_ORDERS WHERE SalesOrderNumber=? group by SalesOrderNumber";
$stmt = $conn->prepare($sql);
// $stmt->bind_param("s", $orderToFetch);
$stmt->execute();
$result = $stmt->get_result();
$num_rows = mysqli_num_rows($result);
if($num_rows > 1) {
?>
<table class="table table-sm table-striped table-hover font-sans-serif fs--1 mt-4">
    <thead>
        <tr>
            <th scope="col">Stock&nbsp;Location</th>
            <th scope="col">Storage&nbsp;Type</th>
            <th scope="col">Stock&nbsp;On&nbsp;Hand</th>
        </tr>
    </thead><tbody>
    <?php
    $flag = true;
    $flag2 = 0;
    while ($row = $result->fetch_assoc()) {
        if($flag === true){
            $v1 .= "<p style='font-size: 18px; font-weight: 'bold'; margin-top: 6px; font-family: var(--falcon-font-sans-serif);' id='code_'>".$row["class"]."</p>";
            $v1 .= "<input type='hidden' id='currentprice' value='".$row["stock"]."' />";
            $flag = false;
        }
        
        if($flag2 === 0) {
            $flag2 = 1;
        } else {
            $v1 .= "<tr>
                <td class='text-nowrap'>" . $row["loc"] . "</td>
                <td class='text-nowrap'>" . $row["class"] . "</td>
                <td class='text-nowrap'>" . $row["stock"] . "</td>
                </tr>";
        }
       
        
    }
    echo $v1;
 ?>
</tbody></table> <?php } else {
    echo "Invalid product code";
    exit;
}
}
