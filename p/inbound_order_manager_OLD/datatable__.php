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
      $searchQuery = " AND (PONumber LIKE :PONumber OR 
           VendorName LIKE :VendorName ) ";
      $searchArray = array( 
           'PONumber'=>"'%$searchValue%'",
           'VendorName'=>"'%$searchValue%'" );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(DISTINCT(PONumber)) as 'allcount' 
   FROM INB_PURCHASE_ORDERS
   WHERE 1 ".$searchQuery);
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(DISTINCT(PONumber)) as 'allcount' 
   FROM INB_PURCHASE_ORDERS
   WHERE 1 ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT
   '' as 'selector',
   PONumber,
   Receiver,
   VendorName,
   Reference,
   OrderValue,
   OrderCreatedOn,
   CreatedBy
   FROM INB_PURCHASE_ORDERS
   WHERE PONumber IS NOT NULL ".$searchQuery." 
   GROUP BY PONumber
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
      $createdon = date('d-m-Y h:i a', strtotime($row['OrderCreatedOn']));

      if($row['Receiver'] === null) {$recv = "<span class='badge badge-soft-primary'>Schedule</span>";} else {$recv = "<span class='badge' style='background-color: var(--falcon-btn-falcon-success-active-background); color: var(--falcon-list-group-item-color-success); min-width: 62px !important'>".$row["Receiver"]."</span>";}
      $data[] = array(
         "selector"=>'<label class="switch"><input type="checkbox" value='. $row['PONumber'] .' name="id[]"><span class="slider"></span></label>',
         "PONumber"=>'<a href="../po-detail/index.php?link='.$row['PONumber'].'" class="orderRef_" id='.$row['PONumber'].'>'.$row['PONumber'].'</a>',
         "receiver"=>$recv,
         "VendorName"=>$row['VendorName'],
         "Reference"=>$row['Reference'],
         "OrderValue"=>$row['OrderValue'],
         "CreatedBy"=>$row['CreatedBy'],
         "OrderCreatedOn"=>$createdon
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