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
$searchByInvoiced = $_POST['searchByInvoiced'];
$searchByCustomer = $_POST['searchByCustomer'];
$searchBySO = $_POST['searchBySO'];
$searchByRef = $_POST['searchByRef'];
$searchByShipday = $_POST['searchByShipday'];
$searchByFrom = $_POST['searchByFrom'];
$searchByTo = $_POST['searchByTo'];

## Search 
$searchQuery = " ";
if($searchByInvoiced != '' && $searchByInvoiced == 'Invoiced'){
    $searchQuery .= " and (pk.InvoiceState LIKE '%".$searchByInvoiced."%') ";
}
if($searchByInvoiced != '' && $searchByInvoiced == 'Pending'){
    $searchQuery .= " and (pk.InvoiceState IS NULL) ";
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
$sel = mysqli_query($conn,"SELECT COUNT(distinct(pk.SalesOrderNumber)) as 'allcount' FROM INB_COMPLETED_PICKS pk WHERE pk.PushedStatus = 'Pushed'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn,"SELECT COUNT(distinct(pk.SalesOrderNumber)) as 'allcount' 
FROM INB_COMPLETED_PICKS pk 
WHERE pk.PushedStatus = 'Pushed' ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];


# Fetch records
// $vQuery = "select * from detail WHERE 1".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$start.",".$rowperpage;

$vQuery = "SELECT
pk.SalesOrderNumber,
pk.PickedBy,
pk.PickedOn,
pk.PickStatus,
pk.PushedStatus,
pk.PushedTime,
pk.Reference,
pk.OrderCustomer,
pk.InvoiceState
FROM INB_COMPLETED_PICKS pk
WHERE pk.PushedStatus = 'Pushed' ".$searchQuery." 
GROUP BY pk.SalesOrderNumber
ORDER BY ".$columnName." ".$columnSortOrder." 
LIMIT ".$start.",".$rowperpage;

$vRecords = mysqli_query($conn, $vQuery);
$data = array();
while ($row = mysqli_fetch_assoc($vRecords)) {
    $pushedon = date('d-m-Y h:i a', strtotime($row['PushedTime']));
    if($row['InvoiceState'] === 'Invoiced') { $invoiced ="<span class='badge' style='background-color: var(--falcon-btn-falcon-success-active-background); color: var(--falcon-list-group-item-color-success); min-width: 62px !important'>Invoiced</span>"; } else { $invoiced = "<span class='badge badge-soft-danger' style='min-width: 62px !important'>Pending</span>";}

    $data[] = array(
        "PrintDocket"=>'<a href="../delivery_docket/index.php?linked='.$row['SalesOrderNumber'].'" target="_blank" rel="noopener noreferrer" class="orderRef_" id='.$row['SalesOrderNumber'].'><i class="fa-solid fa-print"></i></a>',
        "SalesOrderNumber"=>'<a target="_blank" href="../pick_details/index.php?link='.$row['SalesOrderNumber'].'" class="orderRef_" id='.$row['SalesOrderNumber'].'>'.$row['SalesOrderNumber'].'</a>',
        "PickedBy"=>$row['PickedBy'],
        "Reference"=>$row['Reference'],
        "PickedOn"=>$pickedon,
        "PickStatus"=>$row['PickStatus'],
        "PushedStatus"=>$row["PushedStatus"],
        "PushedTime"=>$pushedon,
        "OrderCustomer"=>$row['OrderCustomer'],
        "ShipDay"=>$row['ShipDay'],
        "InvoiceState"=>$invoiced
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
