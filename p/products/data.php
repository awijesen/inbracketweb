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
// $searchBySubModel = $_POST['searchBySubModel'];
// $searchByYear = $_POST['searchByYear'];
// $searchByLeaves = $_POST['searchByLeaves'];
// $searchByPartNo = $_POST['searchByPartNo'];
// $searchByPartNoInput = $_POST['searchByPartNoInput'];
// $searchByOENumber = $_POST['searchByOENumber'];
// $requestFromFilter = $_POST['requestFromFilter'];
## Search 
$searchQuery = " ";
if($searchByActiveStatus != ''){
    $searchQuery .= " and (Active ='".$searchByActiveStatus."' ) ";
}
if($searchByName != ''){
    $searchQuery .= " and (ProductCode LIKE '%".$searchByName."%') ";
}
// if($searchBySubModel != ''){
//     $searchQuery .= " and (sub_model ='".$searchBySubModel."') ";
// }
// if($searchByYear != ''){
//     $searchQuery .= " and (year='".$searchByYear."') ";
// }
// if($searchByLeaves != ''){
//     $searchQuery .= " and (leaves='".$searchByLeaves."') ";
// }
// if($searchByPartNo != '' && $searchByPartNoInput !=''){
//     $searchQuery .= " and (partno='".$searchByPartNo."' AND partno='".$searchByPartNoInput."') ";
// }else{
//     if($searchByPartNo != ''){
//         $searchQuery .= " and (partno='".$searchByPartNo."') ";
//     }
//     if($searchByPartNoInput !=''){
//         $searchQuery .= " and (partno='".$searchByPartNoInput."') ";
//     }
// }

// if($searchByOENumber != ''){
// 	$searchQuery .= " and (oe1 ='".$searchByOENumber."' or 
//     oe2 ='".$searchByOENumber."' or 
//     oe3 ='".$searchByOENumber."' or 
//     oe4 ='".$searchByOENumber."' or 
//     oe5 ='".$searchByOENumber."' or 
//     oe6 ='".$searchByOENumber."' or 
//     oe7 ='".$searchByOENumber."' or 
//     oe8 ='".$searchByOENumber."' or 
//     oe9 ='".$searchByOENumber."' or 
//     oe10 ='".$searchByOENumber."' or 
//     oe11 ='".$searchByOENumber."' or 
//     oe12 ='".$searchByOENumber."' or 
//     oe13 ='".$searchByOENumber."' or 
//     oe14 ='".$searchByOENumber."' or 
//     oe15 ='".$searchByOENumber."' or 
//     oe16 ='".$searchByOENumber."' or 
//     oe17 ='".$searchByOENumber."' or 
//     oe18 ='".$searchByOENumber."' or 
//     oe19 ='".$searchByOENumber."' or 
//     oe20 ='".$searchByOENumber."')";
// }

## Total number of records without filtering
$sel = mysqli_query($conn,"SELECT COUNT(distinct(ProductCode)) as 'allcount' FROM INB_PRODUCT_MASTER");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn,"SELECT COUNT(distinct(ProductCode)) as 'allcount' 
FROM INB_PRODUCT_MASTER
WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

// $makeFilters = "<option value=''>-- Select Make--</option>";
// $modelFilters = "<option value=''>-- Select Model--</option>";
// $subModelFilters = "<option value=''>-- Select Sub Model--</option>";
// $yearFilters = "<option value=''>-- Select Year--</option>";
// $leaveFilters = "<option value=''>-- Select Leave--</option>";
// $partNoFilters = "<option value=''>-- Select Part Number--</option>";
// $partNoInputFilters = "";
// $OENumberFilters = $searchByOENumber;

// if($requestFromFilter){
//     $makeQuery = "select DISTINCT make from detail WHERE make !='' ".$searchQuery." order by make ASC";
//     $makeRecords = mysqli_query($conn, $makeQuery);
//     while ($row = mysqli_fetch_assoc($makeRecords)) {
//         $selected = "";
//         if(($searchByActiveStatus == $row['make'])){
//             $selected = "selected=selected";
//         }
//         $makeFilters.= "<option ".$selected." value='".$row['make']."'>".$row['make']."</option>";
//     }
//     $modelQuery = "select distinct model from detail WHERE model !=''".$searchQuery." order by model ASC";
//     $modelRecords = mysqli_query($conn, $modelQuery);
//     while ($row = mysqli_fetch_assoc($modelRecords)) {
//         $selected = "";
//         if(($searchByName == $row['model'])){
//             $selected = "selected=selected";
//         }
//         $modelFilters.= "<option ".$selected." value='".$row['model']."'>".$row['model']."</option>";
//     }
//     $subModelQuery = "select distinct sub_model from detail WHERE sub_model !=''".$searchQuery." order by sub_model ASC";
//     $subModelRecords = mysqli_query($conn, $subModelQuery);
//     while ($row = mysqli_fetch_assoc($subModelRecords)) {
//         $selected = "";
//         if(($searchBySubModel == $row['sub_model'])){
//             $selected = "selected=selected";
//         }
//         $subModelFilters.= "<option ".$selected." value='".$row['sub_model']."'>".$row['sub_model']."</option>";
//     }

//     $yearQuery = "select distinct year from detail WHERE year !=''".$searchQuery." order by year ASC";
//     $yearRecords = mysqli_query($conn, $yearQuery);
//     while ($row = mysqli_fetch_assoc($yearRecords)) {
//         $selected = "";
//         if(($searchByYear == $row['year'])){
//             $selected = "selected=selected";
//         }
//         $yearFilters.= "<option ".$selected." value='".$row['year']."'>".$row['year']."</option>";
//     }

//     $leaveQuery = "select distinct leaves from detail WHERE leaves !=''".$searchQuery." order by leaves ASC";
//     $leaveRecords = mysqli_query($conn, $leaveQuery);
//     while ($row = mysqli_fetch_assoc($leaveRecords)) {
//         $selected = "";
//         if(($searchByLeaves == $row['leaves'])){
//             $selected = "selected=selected";
//         }
//         $leaveFilters.= "<option ".$selected." value='".$row['leaves']."'>".$row['leaves']."</option>";
//     }
//     $partnoQuery = "select distinct partno from detail WHERE partno !=''".$searchQuery." order by partno ASC";
//     $partnoRecords = mysqli_query($conn, $partnoQuery);
//     while ($row = mysqli_fetch_assoc($partnoRecords)) {
//         $selected = "";
//         if(($searchByPartNo == $row['partno'])){
//             $selected = "selected=selected";
//         }
//         $partNoFilters.= "<option ".$selected." value='".$row['partno']."'>".$row['partno']."</option>";
//     }
// }

# Fetch records
// $vQuery = "select * from detail WHERE 1".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$start.",".$rowperpage;

$vQuery = "SELECT
   ProductCode,
   ProductDescription,
   Barcode,
   CustomFieldOne as 'Group',
   CustomFieldTwo as 'SortDesc',
   Active,
   UOM, 
   format(Pricing_One,2) as 'OBS',
   format(Pricing_Tow, 2) as 'ALPA',
   format(Pricing_Six,2) as 'CEQ',
   format(Pricing_Five,2) as 'Wholesale',
   format(Pricing_Four,2) as 'Staff'
   FROM INB_PRODUCT_MASTER
   WHERE 1 ".$searchQuery."
   GROUP BY ProductCode
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
