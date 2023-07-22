<?php
require('../../dbconnect/db.php');

$CODE =  htmlspecialchars($_POST['autoSizingInputProduct'] ?? '');

if($CODE == '') {
    echo "Product code required";
} else {
$sql =  "SELECT 'Total' as 'loc', '' as 'class', SUM(stock) as 'stock', IDN as 'IDN' from(
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
            <th scope="col">Replenish</th>
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
    while ($row = $result->fetch_assoc()) {
        if($row["class"] == 'Pickface'){
            $pfs = $row["loc"];
        }
        if($row["class"] == 'Bulk'){
            // $addon = "<div class='btn-group btn-group hover-actions end-0 me-4'>
            // <button class='btn btn-light pe-2' type='button' data-bs-toggle='tooltip' data-bs-placement='top' title='".$row["IDN"]."' data-bs-toggle='modal' data-bs-target='#staticBackdrop'><span class='fas fa-edit'></span>";
            $addon = "<div class='btn-group btn-group hover-actions'><div stk_bk_id='".$row["IDN"]."' stk_loc='".$row["loc"]."' stk_pf='".$CODE."' id='replentrigger'><i class='fa-solid fa-arrows-down-to-line'></i></div></div>";
            
        } else {
            $addon='';
        }

        echo "<tr class='hover-actions-trigger'>
                <td class='text-nowrap'>" . $row["loc"] . "</td>
                <td class='text-nowrap'>" . $row["class"] . "</td>
                <td class='text-nowrap'>" . $row["stock"] . "</td>

                <td class='w-auto'>
                 ".$addon."    
                </td>
                </tr>";
    }
 ?>
</tbody></table> <?php } else {
    echo "Invalid product code";
    exit;
}
}
