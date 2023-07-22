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
      $searchQuery = " AND (
           p.ProductCode LIKE :ProductCode OR 
           pp.ProductDescription LIKE :ProductDescription OR
           p.CountLocation LIKE :CountLocation OR 
           p.LocationClass LIKE :LocationClass OR
           p.CountUser LIKE :CountUser OR
           p.CountedOn LIKE :CountedOn ) ";
      $searchArray = array( 
           'ProductCode'=>"%$searchValue%",
           'ProductDescription'=>"%$searchValue%",
           'CountLocation'=>"%$searchValue%",
           'LocationClass'=>"%$searchValue%",
           'CountUser'=>"%$searchValue%",
           'CountedOn'=>"%$searchValue%");
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(p.ProductCode)) as 'allcount' FROM INB_STOCKTAKE_MASTER p");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(p.ProductCode)) as 'allcount' 
   FROM INB_STOCKTAKE_MASTER p
   left outer join INB_PRODUCT_MASTER pp on pp.ProductCode=p.ProductCode
   WHERE p.ProductCode is not null ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT 
   p.ProductCode,
   pp.ProductDescription,
   p.CountLocation,
   p.CorrectPickface,
   p.LocationClass,
   p.CountUser,
   p.CountedOn
   FROM INB_STOCKTAKE_MASTER p
   left outer join INB_PRODUCT_MASTER pp on pp.ProductCode=p.ProductCode 
   WHERE p.ProductCode is not null ".$searchQuery."
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
  
      // if($row["Pastatus"] == 'Pending') {
      //    $cont="<span class='badge' style='background-color: var(--falcon-blue)'>Pending</span>"; 
      // } else {
      //    $cont="<span class='badge' style='background-color: var(--falcon-warning)'>Partial</span>";
      // }
      // $dateToBeInserted = date('d-m-Y h:i a', strtotime($row['ReceivedTimeStamp']));

      $data[] = array(
        //  "selector"=>'<label class="switch"><input type="checkbox" value='. $row['SalesOrderNumber'] .' name="id[]"><span class="slider"></span></label>',
         // "SalesOrderNumber"=>'<a href="../_line_detail/index.php?link='.$row['SalesOrderNumber'].'" class="orderRef_" id='.$row['SalesOrderNumber'].'>'.$row['SalesOrderNumber'].'</a>',
         "ProductCode"=>$row['ProductCode'],
         "ProductDescription"=>$row['ProductDescription'],
         "CountLocation"=>$row['CountLocation'],
         "CorrectPickface"=>$row['CorrectPickface'],
         "LocationClass"=>$row['LocationClass'],
         "CountUser"=>$row['CountUser'],
         "CountedOn"=>$row['CountedOn'],
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