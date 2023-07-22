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
$searchByHasFlags = $_POST['searchByHasFlags'];
$searchByCustomer = $_POST['searchByCustomer'];
$searchBySO = $_POST['searchBySO'];
$searchByRef = $_POST['searchByRef'];
$searchByShipday = $_POST['searchByShipday'];
$searchByFrom = $_POST['searchByFrom'];
$searchByTo = $_POST['searchByTo'];

## Search 
$searchQuery = " ";
if($searchByHasFlags != ''){
    $searchQuery .= " and (pk.CustomerGroupId LIKE '%".$searchByHasFlags."%') ";
}
if($searchByCustomer != ''){
    $searchQuery .= " and (pk.OrderCustomer LIKE '%".$searchByCustomer."%') ";
}
if($searchBySO != ''){
    $searchQuery .= " and (pk.SalesOrderNumber LIKE '%".$searchBySO."%') ";
}
if($searchByRef != ''){
    $searchQuery .= " and (pk.Reference LIKE '%".$searchByRef."%') ";
}
if($searchByShipday != ''){
    $searchQuery .= " and (pk.ShipDay LIKE '%".$searchByShipday."%') ";
}
if($searchByFrom != '' && $searchByTo == ''){
    $searchQuery .= " and (LEFT(pk.PushedTime,10) LIKE '%".$searchByFrom."%') ";
}

if($searchByTo != '' && $searchByFrom != ''){
    $searchQuery .= " and (LEFT(pk.PushedTime,10) BETWEEN '".$searchByFrom."' AND '".$searchByTo."') ";
}

## Total number of records without filtering
$sel = mysqli_query($conn,"SELECT COUNT(distinct(pk.SalesOrderNumber)) as 'allcount' FROM INB_COMPLETED_PICKS pk WHERE pk.PushedStatus = 'Pushed' AND pk.InvoiceState IS NULL");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn,"SELECT COUNT(distinct(pk.SalesOrderNumber)) as 'allcount' 
FROM INB_COMPLETED_PICKS pk
WHERE pk.PushedStatus = 'Pushed' AND pk.InvoiceState IS NULL ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];


# Fetch records
// $vQuery = "select * from detail WHERE 1".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$start.",".$rowperpage;

$vQuery = "SELECT
pk.SalesOrderNumber,
pk.PickedBy,
pk.PickedOn,
pk.PickStatus,
pk.PushedTime,
pk.PushedBy,
pk.PushedStatus,
pk.OrderCustomer,
pk.ShipDay,
pk.Reference,
pk.CustomerGroupId
FROM INB_COMPLETED_PICKS pk
WHERE pk.PushedStatus = 'Pushed' AND pk.InvoiceState IS NULL ".$searchQuery." 
GROUP BY pk.SalesOrderNumber 
ORDER BY ".$columnName." ".$columnSortOrder." 
LIMIT ".$start.",".$rowperpage;

$vRecords = mysqli_query($conn, $vQuery);
$data = array();
while ($row = mysqli_fetch_assoc($vRecords)) {
    $row["CustomerGroupId"] === '11' ? $notes_ = "<span class='badge badge-soft-primary'>+7 Days</span>" : $notes_ = "";
    $data[] = array(
         "SalesOrderNumber"=>'<a href="../_line_detail/index.php?link='.$row['SalesOrderNumber'].'" class="orderRef_" rel="noopener noreferrer" id='.$row['SalesOrderNumber'].'>'.$row['SalesOrderNumber'].'</a>',
         "PrintDocket"=>'<a href="../delivery_docket/index.php?linked='.$row['SalesOrderNumber'].'" target="_blank" class="orderRef_" id='.$row['SalesOrderNumber'].'><i class="fa-solid fa-print"></i></a>',
         "PickedBy"=>$row['PickedBy'],
         "PickedOn"=>$row['PickedOn'],
         "PickStatus"=>$row['PickStatus'],
         "PushedStatus"=>$row["PushedStatus"],
         "PushedTime"=>$row['PushedTime'],
         "PushedBy"=>$row['PushedBy'],
         "OrderCustomer"=>$row['OrderCustomer'],
         "ShipDay"=>$row['ShipDay'],
         "Reference"=>$row['Reference'],
         "Notes"=>$notes_
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
