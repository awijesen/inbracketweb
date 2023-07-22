<?php
   // Database Connection
   include 'connection.php';

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
      $searchQuery = " AND (SalesOrderNumber LIKE :SalesOrderNumber OR 
           OrderCustomer LIKE :OrderCustomer OR
           Reference LIKE :Reference OR 
           CreatedBy LIKE :CreatedBy ) ";
      $searchArray = array( 
           'SalesOrderNumber'=>"%$searchValue%",
           'OrderCustomer'=>"%$searchValue%",
           'Reference'=>"%$searchValue%",
           'CreatedBy'=>"%$searchValue%"
      );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM GRW_INB_SALES_ORDERS ");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM GRW_INB_SALES_ORDERS WHERE 1 ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT * FROM GRW_INB_SALES_ORDERS WHERE 1 ".$searchQuery." GROUP BY SalesOrderNumber ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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
      if($row["Picker"] == '' || $row["Picker"] == null) {
         $pker = "Schedule";
      } else {
         $pker = $row["Picker"];
      }

      $data[] = array(
         "SalesOrderNumber"=>$row['SalesOrderNumber'],
         "Picker"=>$pker,
         "OrderCustomer"=>$row['OrderCustomer'],
         "Reference"=>$row['Reference'],
         "OrderValue"=>$row['OrderValue'],
         "ShipDay"=>$row['ShipDay'],
         "ProcessedDate"=>$row['ProcessedDate'],
         "CreatedBy"=>$row['CreatedBy']
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