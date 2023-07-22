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
$searchByGroup = $_POST['searchByGroup'];
$searchByDescription = $_POST['searchByDescription'];

## Search 
$searchQuery = " ";
// if($searchByActiveStatus != ''){
//     $searchQuery .= " and (ProductCode '".$searchByActiveStatus."' ) ";
// } 
if($searchByName != ''){
    $searchQuery .= " and (p.ProductCode LIKE '%".$searchByName."%') ";
}
if($searchByCategory != ''){
    $searchQuery .= " and (p.LocationClass LIKE '%".$searchByCategory."%') ";
}
if($searchByGroup != ''){
    $searchQuery .= " and (p.CountUser LIKE '%".$searchByGroup."%') ";
}
// if($searchByBarcode != ''){
//     $searchQuery .= " and (Barcode LIKE '%".$searchByBarcode."%') ";
// }
if($searchByDescription != ''){
    $searchQuery .= " and (p.ProductDescription LIKE '%".$searchByDescription."%') ";
}

## Total number of records without filtering
$sel = mysqli_query($conn,"SELECT COUNT(p.ProductCode) as 'allcount' FROM INB_STOCKTAKE_MASTER p");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn,"SELECT COUNT(p.ProductCode) as 'allcount' 
FROM INB_STOCKTAKE_MASTER p
-- left outer join INB_PRODUCT_MASTER pp on pp.ProductCode=p.ProductCode
WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];


# Fetch records
// $vQuery = "select * from detail WHERE 1".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$start.",".$rowperpage;

$vQuery = "SELECT 
p.ID,
p.ProductCode,
p.ProductDescription,
p.CountLocation,
p.LocationClass,
p.CountUser,
p.StocktakeCount,
p.CountedOn
FROM INB_STOCKTAKE_MASTER p
-- left outer join INB_PRODUCT_MASTER pp on pp.ProductCode=p.ProductCode 
WHERE p.ProductCode is not null ".$searchQuery."
GROUP BY p.ID
ORDER BY ".$columnName." ".$columnSortOrder." 
limit ".$start.",".$rowperpage;

$vRecords = mysqli_query($conn, $vQuery);
$data = array();
while ($row = mysqli_fetch_assoc($vRecords)) {
    $data[] = $row;
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
