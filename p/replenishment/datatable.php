<?php
// Database Connection
require(__DIR__ . '/../../dbconnect/connection.php');

// Reading value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

$searchArray = array();

// Search
$searchQuery = " ";
if ($searchValue != '') {
   $searchQuery = " AND (ProductCode LIKE :ProductCode OR 
           ProductDescription LIKE :ProductDescription OR
           FromLocation LIKE :FromLocation OR 
           ToLocation LIKE :ToLocation OR
           ReplenBy LIKE :ReplenBy ) ";
   $searchArray = array(
      'ProductCode' => "%$searchValue%",
      'ProductDescription' => "%$searchValue%",
      'FromLocation' => "%$searchValue%",
      'ToLocation' => "%$searchValue%",
      'ReplenBy' => "%$searchValue%"
   );
}

// Total number of records without filtering
$stmt = $conn->prepare("SELECT COUNT(distinct(ID)) as 'allcount' FROM INB_STOCK_REPLENISHMENT");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

// Total number of records with filtering
$stmt = $conn->prepare("SELECT COUNT(distinct(ID)) as 'allcount' FROM INB_STOCK_REPLENISHMENT WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

// Fetch records
$stmt = $conn->prepare("SELECT
        ID,
        ProductCode,
        ProductDescription,
        FromLocation,
        ToLocation,
        ReplenQty,
        ReplenBy,
        ReplenOn
        FROM INB_STOCK_REPLENISHMENT 
        WHERE 1 " . $searchQuery . " 
         ORDER BY " . $columnName . " " . $columnSortOrder . " 
         LIMIT :limit,:offset");

// Bind values
foreach ($searchArray as $key => $search) {
   $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
}

$stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
$stmt->execute();
$empRecords = $stmt->fetchAll();

$data = array();

foreach ($empRecords as $row) {

   $dateToBeInserted = date('d-m-Y h:i a', strtotime($row['ReplenOn']));

   $data[] = array(
      //  "selector"=>'<label class="switch"><input type="checkbox" value='. $row['SalesOrderNumber'] .' name="id[]"><span class="slider"></span></label>',
      // "SalesOrderNumber"=>'<a href="../_line_detail/index.php?link='.$row['SalesOrderNumber'].'" class="orderRef_" id='.$row['SalesOrderNumber'].'>'.$row['SalesOrderNumber'].'</a>',
      // "PlateNumber" => "<a href='#' class='plate_detail' id='" . $row['PlateNumber'] . "'>" . $row['PlateNumber'] . "</a>",
      "ProductCode" => $row['ProductCode'],
      "ProductDescription" => $row['ProductDescription'],
      "FromLocation" => $row['FromLocation'],
      "ToLocation" => $row['ToLocation'],
      "ReplenQty" => $row['ReplenQty'],
      "ReplenBy" => $row['ReplenBy'],
      "ReplenOn" => $dateToBeInserted
   );
}

// Response
$response = array(
   "draw" => intval($draw),
   "iTotalRecords" => $totalRecords,
   "iTotalDisplayRecords" => $totalRecordwithFilter,
   "aaData" => $data
);

echo json_encode($response);
