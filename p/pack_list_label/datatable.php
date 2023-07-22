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
    $searchQuery = " AND (de.packListId LIKE :packListId OR 
           de.PackedBy LIKE :PackedBy OR
           de.SalesOrderNumber LIKE :SalesOrderNumber OR 
           de.CustomerName LIKE :CustomerName OR 
           de.ConsignmentNote LIKE :ConsignmentNote ) ";
    $searchArray = array(
        'packListId' => "%$searchValue%",
        'PackedBy' => "%$searchValue%",
        'SalesOrderNumber' => "%$searchValue%",
        'CustomerName' => "%$searchValue%",
        'ConsignmentNote' => "%$searchValue%"
    );
}

// Total number of records without filtering
$stmt = $conn->prepare("SELECT COUNT(DISTINCT(de.packListId)) AS allcount 
FROM INB_PACK_LIST_DETAIL de
WHERE de.DispatchStatus is null AND de.Courier is not null ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

// Total number of records with filtering
$stmt = $conn->prepare("SELECT COUNT(DISTINCT(de.packListId)) AS allcount 
FROM INB_PACK_LIST_DETAIL de
WHERE de.DispatchStatus is null AND de.Courier is not null  " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

// Fetch records
$stmt = $conn->prepare("SELECT li.AddressPostCode, li.AddressState, li.AddressStreet, li.AddressSuburb,  sum(distinct(de.PalletCount + de.BoxCount)) as 'Count', de.packListId, de.PackedBy, de.SalesOrderNumber, de.CustomerName, de.ConsignmentNote
    FROM INB_PACK_LIST_DETAIL de 
    LEFT OUTER JOIN INB_CUSTOMER_LIST li on li.CustomerId=de.OrderCustomerId
    WHERE de.DispatchStatus is null AND de.Courier is not null " . $searchQuery . " 
    GROUP BY de.packListId 
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

    // if ($row["Picker"] == '' or $row['Picker'] == null or $row['Picker'] == 'Schedule') {
    //     $pker = "<span class='badge badge-soft-primary'>Schedule</span>";
    // } else if ($row["Picker"] == 'HOLD') {
    //     $pker = "<span class='badge badge-soft-danger' style='min-width: 62px !important'>" . $row["Picker"] . "</span>";
    // } else {
    //     $pker = "<span class='badge' style='background-color: var(--falcon-btn-falcon-success-active-background); color: var(--falcon-list-group-item-color-success); min-width: 62px !important'>" . $row["Picker"] . "</span>";
    // }



    // $dateToBeInserted = date('d-m-Y h:i a', strtotime($row['ProcessedDate'] ?? ''));
    // $date = DateTime::createFromFormat('d/m/Y H:i:s', );
    // $dateToBeInserted = $date->format('Y-m-d H:i:s');

    $data[] = array(
        "selector" => '<label class="switch"><input type="checkbox" value=' . $row['packListId'] . ' name="id[]"><span class="slider"></span></label>',
        "printLabel" => '<a target="_blank" rel="noopener noreferrer" href="../packing_label/index.php?linked=' . $row['packListId'] . '" class="orderRef_" id=' . $row['packListId'] . ' lblcount='.$row['Count'].'>Print</a>',
        "packListId" => $row['packListId'],
        "PackedBy" => $row['PackedBy'],
        "SalesOrderNumber" => $row['SalesOrderNumber'],
        "CustomerName" => $row['CustomerName'],
        "ConsignmentNote" => $row['ConsignmentNote'],
        "lCount" => $row['Count']
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
