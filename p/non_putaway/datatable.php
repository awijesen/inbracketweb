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
      $searchQuery = " AND (PlateNumber LIKE :PlateNumber OR 
           Receiver LIKE :Receiver OR
           PONumber LIKE :PONumber OR 
           ProductCode LIKE :ProductCode OR
           ProductDescription LIKE :ProductDescription ) ";
      $searchArray = array( 
           'PlateNumber'=>"%$searchValue%",
           'Receiver'=>"%$searchValue%",
           'PONumber'=>"%$searchValue%",
           'ProductCode'=>"%$searchValue%",
           'ProductDescription'=>"%$searchValue%");
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(PlateNumber)) as 'allcount' FROM INB_PURCHASE_RECEIPTS");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(PlateNumber)) as 'allcount' FROM INB_PURCHASE_RECEIPTS
   WHERE PutawayStatus = 'InProgress' OR PutawayStatus IS NULL and ReceivedQuantity > 0 and STR_TO_DATE(ReceivedTimeStamp, '%Y-%m-%d') > '2022-12-01' ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT 
   PlateNumber,
   Receiver,
   PONumber,
   ProductCode,
   ProductDescription,
   ReceivedQuantity,
   PutawayQuantity,
   ReceivedTimeStamp,
   CASE
      WHEN PutawayQuantity < ReceivedQuantity and PutawayQuantity > 0 THEN 'Partial'
      WHEN PutawayQuantity < ReceivedQuantity and PutawayQuantity = 0 THEN 'Pending'
   END AS 'Pastatus'
   from INB_PURCHASE_RECEIPTS
   WHERE PutawayStatus = 'InProgress' OR PutawayStatus IS NULL and ReceivedQuantity > 0 and STR_TO_DATE(ReceivedTimeStamp, '%Y-%m-%d') > '2022-12-01' ".$searchQuery." 
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
  
      if($row["Pastatus"] == 'Pending') {
         $cont="<span class='badge' style='background-color: var(--falcon-blue)'>Pending</span>"; 
      } else {
         $cont="<span class='badge' style='background-color: var(--falcon-warning)'>Partial</span>";
      }
      $dateToBeInserted = date('d-m-Y h:i a', strtotime($row['ReceivedTimeStamp']));

      $data[] = array(
        //  "selector"=>'<label class="switch"><input type="checkbox" value='. $row['SalesOrderNumber'] .' name="id[]"><span class="slider"></span></label>',
         // "SalesOrderNumber"=>'<a href="../_line_detail/index.php?link='.$row['SalesOrderNumber'].'" class="orderRef_" id='.$row['SalesOrderNumber'].'>'.$row['SalesOrderNumber'].'</a>',
         "PlateNumber"=>"<a href='#' class='plate_detail' id='".$row['PlateNumber']."'>".$row['PlateNumber']."</a>",
         "Receiver"=>$row['Receiver'],
         "PONumber"=>$row['PONumber'],
         "ProductCode"=>$row['ProductCode'],
         "ProductDescription"=>$row['ProductDescription'],
         "ReceivedQuantity"=>$row['ReceivedQuantity'],
         "PutawayQuantity"=>$row['PutawayQuantity'],
         "ReceivedTimeStamp"=>$dateToBeInserted,
         "pastatus"=>$cont
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