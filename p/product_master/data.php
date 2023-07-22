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
if($searchByActiveStatus != ''){
    $searchQuery .= " and (Active ='".$searchByActiveStatus."' ) ";
}
if($searchByName != ''){
    $searchQuery .= " and (ProductCode LIKE '%".$searchByName."%') ";
}
if($searchByCategory != ''){
    $searchQuery .= " and (CustomFieldOne LIKE '%".$searchByCategory."%') ";
}
if($searchByGroup != ''){
    $searchQuery .= " and (CustomFieldTwo LIKE '%".$searchByGroup."%') ";
}
if($searchByBarcode != ''){
    $searchQuery .= " and (Barcode LIKE '%".$searchByBarcode."%') ";
}
if($searchByDescription != ''){
    $searchQuery .= " and (ProductDescription LIKE '%".$searchByDescription."%') ";
}

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


# Fetch records
// $vQuery = "select * from detail WHERE 1".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$start.",".$rowperpage;

$vQuery = "SELECT
   ProductCode,
   ProductDescription,
   Barcode,
   CustomFieldTwo,
   CustomFieldOne,
   case 
   when Active = true then 'Active'
   else 'Inactive'
   end as 'Active',
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
// while ($row = mysqli_fetch_assoc($vRecords)) {
    foreach ($vRecords as $row) {
    $data[] = array(
    // $data[] = $row;
    // "ProductCode" => '<a href="" class="or_" id='.$row['ProductCode'].'>'.$row['ProductCode'].'</a>',
    "ProductCode" => '<a href="" class="codeFlag_" id='.$row["ProductCode"].'>'.$row["ProductCode"].'</a>',
    "ProductDescription" => $row["ProductDescription"],
    "Barcode" => $row["Barcode"],
    "CustomFieldOne" => $row["CustomFieldOne"],
    "CustomFieldTwo" => $row["CustomFieldTwo"],
    "Active" => $row["Active"],
    "UOM" => $row["UOM"],
    "OBS" => $row["OBS"],
    "ALPA" => $row["ALPA"],
    "CEQ" => $row["CEQ"],
    "Wholesale" => $row["Wholesale"],
    "Staff" => $row["Staff"]
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
