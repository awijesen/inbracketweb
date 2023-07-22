<?php
session_start();
require('../../dbconnect/db.php');

$CODE =  htmlspecialchars($_POST['autoSizingInputProduct'] ?? '');

if($CODE == '') {
    echo "Product code required";
} else {
$sql =  "SELECT 
ProductCode as 'loc',
ProductDescription as 'class',
Pricing_Tow as 'stock',
'' as 'IDN' 
FROM INB_PRODUCT_MASTER
WHERE ProductCode='".$CODE."'
GROUP BY ProductCode
UNION ALL
SELECT 'Total' as 'loc', '' as 'class', SUM(stock) as 'stock', IDN as 'IDN' from(
                SELECT
                Pickface as 'loc',
                'Pickface' as 'class',
                PickfaceStock as 'stock',
                ID as 'IDN' 
                FROM INB_PICKFACE_STOCK 
                WHERE ProductCode='".$CODE."'
                UNION ALL
                SELECT 
                BulkLocation as 'loc',
                'Bulk' as 'class',
                BulkStock as 'stock',
                ID as 'IDN'
                FROM INB_BULK_STOCK 
                WHERE ProductCode='".$CODE."' 
                ORDER BY class DESC) as tbl
                union all
                SELECT
                Pickface as 'loc',
                'Pickface' as 'class',
                PickfaceStock as 'stock',
                ID as 'IDN' 
                FROM INB_PICKFACE_STOCK 
                WHERE ProductCode='".$CODE."'
                UNION ALL
                SELECT 
                BulkLocation as 'loc',
                'Bulk' as 'class',
                BulkStock as 'stock',
                ID as 'IDN'
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
            <?php 
            if($_SESSION["ROLE"] == 'super_admin' || $_SESSION["ROLE"] == 'local_manager' || $_SESSION["ROLE"] == 'local_admin') {
                echo '<th scope="col">Replenish</th>';
            } else {
                echo '<th></th>';
            }
            ?>
        </tr>
    </thead><tbody>

    <!-- <table id="dataRef" class="table table-sm table-hover overflow-hidden font-sans-serif fs--1">
                <thead>
                <tr>
                <th></th>
                <th></th>
                <th></th>
                </tr> 
                </thead> -->
    <?php
        $flag = true;
    while ($row = $result->fetch_assoc()) {
        if(!$flag) {
        if($row["class"] == 'Pickface'){
            $pfs = $row["Pickface"];
        }
        if($row["class"] == 'Bulk'){
            if($_SESSION["ROLE"] == 'super_admin' || $_SESSION["ROLE"] == 'local_manager' || $_SESSION["ROLE"] == 'local_admin') {
            // $addon = "<div class='btn-group btn-group hover-actions end-0 me-4'>
            // <button class='btn btn-light pe-2' type='button' data-bs-toggle='tooltip' data-bs-placement='top' title='".$row["IDN"]."' data-bs-toggle='modal' data-bs-target='#staticBackdrop'><span class='fas fa-edit'></span>";
            $addon = "<td class='w-auto'><div class='btn-group btn-group hover-actions'>
            <div stk_bk_id='".$row["IDN"]."' stk_loc='".$row["loc"]."' stk_pf='".$CODE."' stock_holding='".$row["stock"]."' id='replentrigger'>
            <button class='btn btn-sm'><i class='fa-solid fa-arrows-down-to-line'></i></button>
            </div>
            </div></td>";
            } else {
                $addon ='<td></td>';
            }
            
        } else {
            $addon='<td></td>';
        }

        echo "<tr class='hover-actions-trigger'>
                <td class='text-nowrap'>" . $row["loc"] . "</td>
                <td class='text-nowrap'>" . $row["class"] . "</td>
                <td class='text-nowrap'>" . $row["stock"] . "</td>

                
                 $addon   
                
                </tr>";
    } else {
        echo $row["class"];
    }
    
    $flag = false;
    }
 ?>
</tbody></table> <?php } else {
    echo "Invalid product code";
    exit;
}
}
