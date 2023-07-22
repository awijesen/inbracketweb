<?php
  require ('../../dbconnect/db.php');

## Read value
$draw = $_POST['draw'];
$start = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

## Custom Field value
$searchByActiveStatus = $_POST['searchByActiveStatus'];
$searchByName = $_POST['searchByName'];
$searchByCategory = $_POST['searchByCategory'];
$searchByBarcode = $_POST['searchByBarcode'];
$searchByVendor = $_POST['searchByVendor'];
$searchByDescription = $_POST['searchByDescription'];

## Search 
$searchQuery = " ";
if($searchByActiveStatus != ''){
    $searchQuery .= " and (ms.Active ='".$searchByActiveStatus."' ) ";
}
if($searchByName != ''){
    $searchQuery .= " and (ms.ProductCode LIKE '%".$searchByName."%') ";
}
if($searchByCategory != ''){
    $searchQuery .= " and (ms.CustomFieldOne LIKE '%".$searchByCategory."%') ";
}
if($searchByVendor != ''){
    $searchQuery .= " and (ms.Vendor ='".$searchByVendor."' ) ";
}
// if($searchByBarcode != ''){
//     $searchQuery .= " and (Barcode LIKE '%".$searchByBarcode."%') ";
// }
if($searchByDescription != ''){
    $searchQuery .= " and (ms.ProductDescription LIKE '%".$searchByDescription."%') ";
}

## Total number of records without filtering
$sel = mysqli_query($conn,"SELECT COUNT(distinct(ProductCode)) as 'allcount' FROM INB_PRODUCT_MASTER");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn,"SELECT 
count(distinct(ms.ProductCode)) as 'allcount'
FROM INB_PRODUCT_MASTER ms
LEFT OUTER JOIN INB_PICKFACE_STOCK pf on pf.ProductCode=ms.ProductCode
LEFT OUTER JOIN (select sum(bk.BulkStock) as 'BulkStock', bk.ProductCode from INB_BULK_STOCK bk group by bk.ProductCode) as t on t.ProductCode=ms.ProductCode
LEFT OUTER JOIN (
SELECT ord.ProductCode, sum(ord.OrderQuantity) as 'Allocated' 
FROM GRW_INB_SALES_ORDERS ord
WHERE ord.ProductCode NOT IN(select p.ProductCode from INB_ORDER_PICKS p WHERE p.ProductCode=ord.ProductCode and p.SalesOrderNumber=ord.SalesOrderNumber) 
AND ord.ProductCode NOT IN(select pp.ProductCode from INB_COMPLETED_PICKS pp WHERE pp.ProductCode=ord.ProductCode and pp.SalesOrderNumber=ord.SalesOrderNumber)
GROUP BY ord.ProductCode) as j on j.ProductCode=ms.ProductCode
WHERE 1 ".$searchQuery."");

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];


# Fetch records
// $vQuery = "select * from detail WHERE 1".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$start.",".$rowperpage;

$vQuery = "SELECT 
ms.ProductCode, 
ms.ProductDescription, 
ms.Barcode, 
ms.CustomFieldOne as 'Category',
ms.Active,
IFNULL(pf.PickfaceStock, 0) as 'PickfaceStock', 
IFNULL(t.BulkStock, 0) as 'BulkStock', 
(IFNULL(pf.PickfaceStock, 0) + IFNULL(t.BulkStock, 0)) AS 'TotalStock', 
IFNULL(j.Allocated, 0) AS 'Allocated', 
IFNULL(((IFNULL(pf.PickfaceStock, 0) + IFNULL(t.BulkStock, 0)) - IFNULL(j.Allocated,0)),0) as 'FreeStockOnShelf',
ms.Vendor,
ms.VendorProductCode  
FROM INB_PRODUCT_MASTER ms
LEFT OUTER JOIN INB_PICKFACE_STOCK pf on pf.ProductCode=ms.ProductCode
LEFT OUTER JOIN (select sum(bk.BulkStock) as 'BulkStock', bk.ProductCode from INB_BULK_STOCK bk group by bk.ProductCode) as t on t.ProductCode=ms.ProductCode
LEFT OUTER JOIN (
SELECT ord.ProductCode, sum(ord.OrderQuantity) as 'Allocated' 
FROM GRW_INB_SALES_ORDERS ord
WHERE ord.ProductCode NOT IN(select p.ProductCode from INB_ORDER_PICKS p WHERE p.ProductCode=ord.ProductCode and p.SalesOrderNumber=ord.SalesOrderNumber) 
AND ord.ProductCode NOT IN(select pp.ProductCode from INB_COMPLETED_PICKS pp WHERE pp.ProductCode=ord.ProductCode and pp.SalesOrderNumber=ord.SalesOrderNumber)
GROUP BY ord.ProductCode) as j on j.ProductCode=ms.ProductCode 
WHERE 1 ".$searchQuery."
GROUP BY ms.ProductCode
ORDER BY ".$columnName." ".$columnSortOrder." 
limit ".$start.",".$rowperpage;

$vRecords = mysqli_query($conn, $vQuery);
$data = array();
while ($row = mysqli_fetch_assoc($vRecords)) {
    if($row['Active'] === '1') {
        $act = 'Active';
    } else {
        $act = 'Inactive';
    }

    $data[] = array(
        // "PrintDocket"=>'<a href="../delivery_docket/index.php?linked='.$row['SalesOrderNumber'].'" target="_blank" rel="noopener noreferrer" class="orderRef_" id='.$row['SalesOrderNumber'].'><i class="fa-solid fa-print"></i></a>',
        "SalesOrderNumber"=>'<a href="../pick_details/index.php?link='.$row['SalesOrderNumber'].'" class="orderRef_" id='.$row['SalesOrderNumber'].'>'.$row['SalesOrderNumber'].'</a>',
        "ProductCode"=>$row['ProductCode'],
        "ProductDescription"=>$row['ProductDescription'],
        "Barcode"=>$row['Barcode'],
        "Category"=>$row['Category'],
        "Active"=> $act,
        "PickfaceStock"=>$row['PickfaceStock'],
        "BulkStock"=>$row['BulkStock'],
        "TotalStock"=>$row['TotalStock'],
        "Allocated"=>$row['Allocated'],
        "FreeStockOnShelf"=>$row['FreeStockOnShelf'],
        "Vendor"=>$row['Vendor'],
        "VendorProductCode"=>$row['VendorProductCode']
      );
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data,
    // "makeFilters"=> $makeFilters,
    // "modelFilters"=> $modelFilters,
    // "subModelFilters"=> $subModelFilters,
    // "yearFilters"=> $yearFilters ,
    // "leaveFilters"=> $leaveFilters,
    // "partNoFilters"=> $partNoFilters,
    // "partNoInputFilters"=> $partNoInputFilters,
    // "OENumberFilters"=> $OENumberFilters,
);

echo json_encode($response);
