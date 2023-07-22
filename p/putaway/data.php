<?php
require('../../dbconnect/db.php');

## Read value
$draw = $_POST['draw'];
$start = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

## Custom Field value
$searchByPO = $_POST['searchByPO'];
$searchByName = $_POST['searchByName'];
$searchByBin = $_POST['searchByBin'];
$searchByBarcode = $_POST['searchByBarcode'];
$searchByUser = $_POST['searchByUser'];
$searchByDescription = $_POST['searchByDescription'];

## Search 
$searchQuery = " ";
if ($searchByPO != '') {
    $searchQuery .= " and (PONumber LIKE '%" . $searchByPO . "%' ) ";
}
if ($searchByName != '') {
    $searchQuery .= " and (ProductCode LIKE '%" . $searchByName . "%') ";
}
if ($searchByBin != '') {
    $searchQuery .= " and (PutawayLocation LIKE '%" . $searchByBin . "%') ";
}
if ($searchByUser != '') {
    $searchQuery .= " and (PutawayUser LIKE '%" . $searchByUser . "%') ";
}
if ($searchByDescription != '') {
    $searchQuery .= " and (ProductDescription LIKE '%" . $searchByDescription . "%') ";
}

## Total number of records without filtering
$sel = mysqli_query($conn, "SELECT COUNT(distinct(ProductCode)) as 'allcount' FROM INB_PURCHASE_PUTAWAY");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn, "SELECT COUNT(distinct(ProductCode)) as 'allcount' 
FROM INB_PURCHASE_PUTAWAY
WHERE 1 " . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];


# Fetch records
// $vQuery = "select * from detail WHERE 1".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$start.",".$rowperpage;

$vQuery = "SELECT
    PONumber,
    PlateNumber,
    ProductCode,
    ProductDescription,
    PutawayQuantity,
    PutawayLocation,
    PutawayTimeStamp,
    PutawayUser
    FROM INB_PURCHASE_PUTAWAY
    WHERE 1 " . $searchQuery . "
    ORDER BY " . $columnName . " " . $columnSortOrder . " 
    limit " . $start . "," . $rowperpage;

$vRecords = mysqli_query($conn, $vQuery);
$data = array();
while ($row = mysqli_fetch_assoc($vRecords)) {
    $pushedon = date('d-m-Y h:i a', strtotime($row['PutawayTimeStamp']));
    $data[] = array(
        "PONumber"=>$row['PONumber'],
        "PlateNumber"=>$row['PlateNumber'],
        "ProductCode"=>$row['ProductCode'],
        "ProductDescription"=>$row['ProductDescription'],
        "PutawayQuantity"=>$row["PutawayQuantity"],
        "PutawayLocation"=>$row['PutawayLocation'],
        "PutawayTimeStamp"=>$pushedon,
        "PutawayUser"=>$row['PutawayUser'],
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
