<?php
   // Database Connection
   require (__DIR__.'/../../dbconnect/connection.php');

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
   if($searchValue != ''){
      $searchQuery = " AND (packListId LIKE :packListId OR 
           CustomerName LIKE :CustomerName OR
           SalesOrderNumber LIKE :SalesOrderNumber OR 
           PackedBy LIKE :PackedBy OR 
           Courier LIKE :Courier OR
           ConsignmentNote LIKE :ConsignmentNote OR
           DispatchBy LIKE :DispatchBy )";
      $searchArray = array( 
           'packListId'=>"%$searchValue%",
           'CustomerName'=>"%$searchValue%",
           'SalesOrderNumber'=>"%$searchValue%",
           'PackedBy'=>"%$searchValue%",
           'Courier'=>"%$searchValue%", 
           'ConsignmentNote'=>"%$searchValue%",
           'DispatchBy'=>"%$searchValue%" );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(ID)) as 'allcount' FROM INB_PACK_LIST_DETAIL");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(ID)) as 'allcount' FROM INB_PACK_LIST_DETAIL WHERE 1 ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT
      ID, 
      packListId,
      CustomerName,
      SalesOrderNumber,
      PalletCount,
      BoxCount,
      PackedOn,
      PackedBy,
      Courier,
      ConsignmentNote,
      DispatchStatus,
      DispatchOn,
      DispatchBy
      FROM INB_PACK_LIST_DETAIL 
      WHERE 1 ".$searchQuery."
      ORDER BY ".$columnName." ".$columnSortOrder." 
      LIMIT :limit,:offset");

   // Bind values
   foreach ($searchArray as $key=>$search) {
      $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
   }

   $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
   $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
   $stmt->execute();
   $empRecords = $stmt->fetchAll();

   $data = array();

   foreach ($empRecords as $row) {
  
      if($row['DispatchStatus'] === null) {
         $flag_ = "<span class='badge' style='background-color: var(--falcon-red); min-width: 60px !important'>Pending</span>";
      } else if($row['CustomFlag'] === 'P1') {
         $flag_ = "<span class='badge' style='background-color: var(--falcon-green); min-width: 60px !important'>Dispatched</span>";
      }

    $dateToBeInserted = date('d-m-Y h:i a', strtotime($row['PackedOn']));
    if($row['DispatchOn'] == null) 
    {

    } else {
      $dateToBeIn = date('d-m-Y h:i a', strtotime($row['DispatchOn']));
   }
      $data[] = array(
         "packListId"=>$row['packListId'],
         "CustomerName"=>$row['CustomerName'],
         "SalesOrderNumber"=>$row['SalesOrderNumber'],
         "PalletCount"=>$row['PalletCount'],
         "BoxCount"=>$row["BoxCount"],
         "PackedOn"=>$dateToBeInserted,
         "PackedBy"=>$row['PackedBy'],
         "Courier"=>$row['Courier'],
         "ConsignmentNote"=>$row['ConsignmentNote'],
         "DispatchStatus"=>$flag_,
         "DispatchOn"=>$dateToBeIn,
         "DispatchBy"=>$row['DispatchBy']
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