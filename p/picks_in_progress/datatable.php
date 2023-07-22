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
      $searchQuery = " AND (SalesOrderNumber LIKE :SalesOrderNumber OR 
           OrderCustomer LIKE :OrderCustomer OR
           Reference LIKE :Reference OR 
           ShipDay LIKE :ShipDay OR 
           Picker LIKE :Picker OR
           CustomFlag LIKE :CustomFlag )";
      $searchArray = array( 
           'SalesOrderNumber'=>"%$searchValue%",
           'OrderCustomer'=>"%$searchValue%",
           'Reference'=>"%$searchValue%",
           'ShipDay'=>"%$searchValue%",
           'Picker'=>"%$searchValue%", 
           'CustomFlag'=>"%$searchValue%" );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(pk.SalesOrderNumber)) as 'allcount', pk.Picker FROM GRW_INB_ASSIGNED_ORDERS pk WHERE pk.Picker <> 'HOLD'");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(pk.SalesOrderNumber)) as 'allcount', pk.Picker FROM GRW_INB_ASSIGNED_ORDERS pk WHERE pk.Picker <> 'HOLD' ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT 
    ord.SalesOrderNumber,
    ord.Picker,
    ord.OrderCustomer,
    ord.Reference,
    ord.ShipDay,
    ord.AssignedOn,
    ord.CustomFlag,
    count(ord.ProductCode) as 'TotalLines',
    (SELECT count(pk.ProductCode) FROM INB_ORDER_PICKS pk WHERE pk.SalesOrderNumber=ord.SalesOrderNumber) as 'PickedLines',
    round((SELECT count(pk.ProductCode) FROM INB_ORDER_PICKS pk WHERE pk.SalesOrderNumber=ord.SalesOrderNumber)/count(ord.ProductCode)*100, 0) as 'Percentage'
    from GRW_INB_ASSIGNED_ORDERS ord 
    WHERE ord.OrderStatus IS NULL AND ord.Picker <> 'HOLD' ".$searchQuery." 
    GROUP BY ord.SalesOrderNumber
    ORDER BY ".$columnName." ".$columnSortOrder." 
    LIMIT :limit,:offset");

   // Bind values261106
   foreach ($searchArray as $key=>$search) {
      $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
   }

   $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
   $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
   $stmt->execute();
   $empRecords = $stmt->fetchAll();

   $data = array();

   foreach ($empRecords as $row) {
  
      if($row['CustomFlag'] === 'P0') {
         $flag_ = "<span class='badge' style='background-color: var(--falcon-red); min-width: 60px !important'>Urgent</span>";
      } else if($row['CustomFlag'] === 'P1') {
         $flag_ = "<span class='badge' style='background-color: var(--falcon-red); min-width: 60px !important'>Priority 1</span>";
      } else if($row['CustomFlag'] === 'P2') {
         $flag_ = "<span class='badge' style='background-color: var(--falcon-red); min-width: 60px !important'>Priority 2</span>";
      } else if($row['CustomFlag'] === 'P3') {
         $flag_ = "<span class='badge' style='background-color: var(--falcon-red); min-width: 60px !important'>Priority 3</span>";
      } else if($row['CustomFlag'] === 'P4') {
         $flag_ = "<span class='badge' style='background-color: var(--falcon-red); min-width: 60px !important'>Priority 4</span>";
      } else if($row['CustomFlag'] === 'P5') {
         $flag_ = "<span class='badge' style='background-color: var(--falcon-red); min-width: 60px !important'>Priority 5</span>";
      } else if($row['CustomFlag'] === 'P6') {
         $flag_ = "<span class='badge' style='background-color: var(--falcon-red); min-width: 60px !important'>Priority 6</span>";
      } else {
         $flag_ = "";
      }

      if($row['Percentage'] == '100') {
         $percentage = "<span class='badge badge-soft-success' style='min-width: 50px !important'>".$row['Percentage']." %</span>";
      } else if($row['Percentage'] > 0 && $row['Percentage'] < 100) {
         $percentage = "<span class='badge badge-soft-dark' style='min-width: 50px !important'>".$row['Percentage']." %</span>";
      } else if($row['Percentage'] > 100) {
         $percentage = "<span class='badge badge-soft-danger' style='min-width: 50px !important'>Review</span>";
      } else {
         $percentage = "<span class='badge badge-soft-primary' style='min-width: 50px !important'>".$row['Percentage']." %</span>";
       } 

    $dateToBeInserted = date('d-m-Y h:i a', strtotime($row['AssignedOn']));

      $data[] = array(
        //  "selector"=>'<label class="switch"><input type="checkbox" value='. $row['SalesOrderNumber'] .' name="id[]"><span class="slider"></span></label>',
         "SalesOrderNumber"=>'<a href="../picks_in_progress_detail/index.php?link='.$row['SalesOrderNumber'].'" class="orderRef_" id='.$row['SalesOrderNumber'].'>'.$row['SalesOrderNumber'].'</a>',
         "OrderCustomer"=>$row['OrderCustomer'],
         "Reference"=>$row['Reference'],
         "ShipDay"=>$row['ShipDay'],
         "Picker"=>$row["Picker"],
         "AssignedOn"=>$dateToBeInserted,
         "TotalLines"=>$row['TotalLines'],
         "PickedLines"=>$row['PickedLines'],
         "Percentage"=> $percentage,
         "CustomFlag"=>$flag_,
         "markUrgent"=>'<a href="#" class="orderFlag_" status="'.$row['CustomFlag'].'" id="'.$row['SalesOrderNumber'].'"><i class="fa-solid fa-pen-to-square"></i></a>',

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