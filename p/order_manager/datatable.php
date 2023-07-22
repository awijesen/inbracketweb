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
           CreatedBy LIKE :CreatedBy ) ";
      $searchArray = array( 
           'SalesOrderNumber'=>"%$searchValue%",
           'OrderCustomer'=>"%$searchValue%",
           'Reference'=>"%$searchValue%",
           'ShipDay'=>"%$searchValue%",
           'CreatedBy'=>"%$searchValue%"      );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(DISTINCT(SalesOrderNumber)) AS allcount 
   FROM GRW_INB_SALES_ORDERS AS ORD 
   WHERE 1 AND 
   NOT EXISTS (SELECT PK.SalesOrderNumber FROM INB_ORDER_PICKS PK WHERE PK.SalesOrderNumber=ORD.SalesOrderNumber)
   AND NOT EXISTS (SELECT CM.SalesOrderNumber FROM INB_COMPLETED_PICKS CM WHERE CM.SalesOrderNumber=ORD.SalesOrderNumber)");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(DISTINCT(SalesOrderNumber)) AS allcount 
   FROM GRW_INB_SALES_ORDERS AS ORD 
   WHERE 1 ".$searchQuery." AND 
   NOT EXISTS (SELECT PK.SalesOrderNumber FROM INB_ORDER_PICKS PK WHERE PK.SalesOrderNumber=ORD.SalesOrderNumber)
   AND NOT EXISTS (SELECT CM.SalesOrderNumber FROM INB_COMPLETED_PICKS CM WHERE CM.SalesOrderNumber=ORD.SalesOrderNumber)");
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT 
   ASS.Picker, 
   ord.OrderNotes,
   ord.SalesOrderNumber, 
   ord.OrderCustomer, 
   ord.Reference, 
   CONCAT('$', FORMAT(CAST(ord.OrderValue as DECIMAL(30,2)),2)) as 'OrderValue', 
   ord.ShipDay, 
   ord.ProcessedDate,
   ord.CreatedBy,
   case 
   when ord.SortCodeDescription = 'C' then 'C'
   when ord.SortCodeDescription = 'T' then 'T'
   else '' end as 'orderType',
   ASS.OnHoldReason
   FROM GRW_INB_SALES_ORDERS as ord
   LEFT OUTER JOIN (SELECT SalesOrderNumber as 'SO', Picker, OnHoldReason from GRW_INB_ASSIGNED_ORDERS group by SalesOrderNumber) as ASS ON ASS.SO = ord.SalesOrderNumber
   WHERE 1 ".$searchQuery." 
   AND NOT EXISTS (SELECT PK.SalesOrderNumber FROM INB_ORDER_PICKS PK WHERE PK.SalesOrderNumber=ord.SalesOrderNumber) 
   AND NOT EXISTS (SELECT CM.SalesOrderNumber FROM INB_COMPLETED_PICKS CM WHERE CM.SalesOrderNumber=ord.SalesOrderNumber)
   GROUP BY ord.SalesOrderNumber 
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
  
      if($row["Picker"] == '' OR $row['Picker'] == null OR $row['Picker'] == 'Schedule') {
         $pker = "<span class='badge badge-soft-primary'>Schedule</span>";
      } else if ($row["Picker"] == 'HOLD') {
         $pker = "<span class='badge badge-soft-danger' style='min-width: 62px !important'>".$row["Picker"]."</span>";
      } else {
         $pker = "<span class='badge' style='background-color: var(--falcon-btn-falcon-success-active-background); color: var(--falcon-list-group-item-color-success); min-width: 62px !important'>".$row["Picker"]."</span>";
      }
      if($row['orderType'] =='C' ) {
         $clothing ='<i class="fas fa-circle" style="font-size:8px; color: rgb(9, 87, 189)"></i>';
      } else if($row['orderType'] =='T') {
         $clothing ='<i class="fas fa-circle" style="font-size:8px; color: rgb(255, 0, 0)"></i>';
      } else {
         $clothing = '';
      }

      if($row["OnHoldReason"] == null) {
         $onholdreason = '';
      } else {
         $onholdreason = "<i id='reason-view' orderref='".$row["SalesOrderNumber"]."' rmessage='".$row["OnHoldReason"]."' class='fa-solid fa-pause' style='color: var(--falcon-gray); font-size: 14px !important; margin-top:2px'></i>";
         // "<span id='reason-view' orderref='".$row["SalesOrderNumber"]."' rmessage='".$row["OnHoldReason"]."' class='fas fa-sticky-note fs-5' style='color: var(--falcon-gray); font-size: 14px !important; margin-top:2px'></span>";
      }

      if($row["OrderNotes"] == null || $row["OrderNotes"] == '') {
         $ordnotes = '';
      } else {
         $ordnotes = "<span id='notes-view' orderreff='".$row["SalesOrderNumber"]."' rdmessage='".$row["OrderNotes"]."' class='fa-sharp fa-solid fa-file-pen fs-5' style='color: var(--falcon-blue); font-size: 14px !important; margin-top:2px'></span>";
      }

      $dateToBeInserted = date('d-m-Y h:i a', strtotime($row['ProcessedDate'] ?? ''));
      // $date = DateTime::createFromFormat('d/m/Y H:i:s', );
      // $dateToBeInserted = $date->format('Y-m-d H:i:s');

      $data[] = array(
         "selector"=>'<label class="switch"><input type="checkbox" value='. $row['SalesOrderNumber'] .' name="id[]"><span class="slider"></span></label>',
         "SalesOrderNumber"=>'<a href="../so-details/index.php?link='.$row['SalesOrderNumber'].'" class="orderRef_" id='.$row['SalesOrderNumber'].'>'.$row['SalesOrderNumber'].'</a>',
         "orderType"=>$clothing,
         "OnHoldReason"=>$onholdreason,
         "Picker"=>$pker,
         "OrderCustomer"=>$row['OrderCustomer'],
         "Reference"=>$row['Reference'],
         "OrderValue"=>$row['OrderValue'],
         "ShipDay"=>$row['ShipDay'],
         "ProcessedDate"=>$dateToBeInserted,
         "CreatedBy"=>$row['CreatedBy'],
         "OrderNotes"=>$ordnotes
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