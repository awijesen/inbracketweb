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
      $searchQuery = " AND (ord.PONumber LIKE :PONumber OR 
           ord.VendorName LIKE :VendorName OR
           ord.Reference LIKE :Reference OR 
           ord.CreatedBy LIKE :CreatedBy ) ";
      $searchArray = array( 
           'PONumber'=>"%$searchValue%",
           'VendorName'=>"%$searchValue%",
           'Reference'=>"%$searchValue%",
           'CreatedBy'=>"%$searchValue%"      );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(DISTINCT(ord.PONumber)) AS allcount 
   FROM INB_PURCHASE_ORDERS ord
   LEFT OUTER JOIN INB_ASSIGNED_PURCHASE_ORDERS ass on ass.PurchaseOrderNumber=ord.PONumber AND ass.ProductCode=ord.ProductCode
   WHERE ord.PONumber NOT IN(SELECT r.PONumber FROM INB_PURCHASE_RECEIPTS r)");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(DISTINCT(ord.PONumber)) AS allcount 
   FROM INB_PURCHASE_ORDERS ord
   LEFT OUTER JOIN INB_ASSIGNED_PURCHASE_ORDERS ass on ass.PurchaseOrderNumber=ord.PONumber AND ass.ProductCode=ord.ProductCode
   WHERE ord.PONumber NOT IN(SELECT r.PONumber FROM INB_PURCHASE_RECEIPTS r)".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT 
   ord.PONumber,
   ord.VendorName,
   ord.OrderCreatedOn,
   ord.Reference,
   ord.OrderValue,
   ass.Receiver,
   ord.CreatedBy
   FROM INB_PURCHASE_ORDERS ord
   LEFT OUTER JOIN INB_ASSIGNED_PURCHASE_ORDERS ass on ass.PurchaseOrderNumber=ord.PONumber AND ass.ProductCode=ord.ProductCode
   WHERE 1 ".$searchQuery." and ord.PONumber NOT IN(SELECT r.PONumber FROM INB_PURCHASE_RECEIPTS r) 
   GROUP BY ord.PONumber;
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
  
      if($row["Receiver"] == '' OR $row['Receiver'] == null OR $row['Receiver'] == 'Schedule') {
         $pker = "<span class='badge badge-soft-primary'>Schedule</span>";
      } else if ($row["Receiver"] == 'HOLD') {
         $pker = "<span class='badge badge-soft-danger' style='min-width: 62px !important'>".$row["Receiver"]."</span>";
      } else {
         $pker = "<span class='badge' style='background-color: var(--falcon-btn-falcon-success-active-background); color: var(--falcon-list-group-item-color-success); min-width: 62px !important'>".$row["Receiver"]."</span>";
      }

      $dateToBeInserted = date('d-m-Y h:i a', strtotime($row['OrderCreatedOn']));
      // $date = DateTime::createFromFormat('d/m/Y H:i:s', );
      // $dateToBeInserted = $date->format('Y-m-d H:i:s');

      $data[] = array(
         "selector"=>'<label class="switch"><input type="checkbox" value='. $row['PONumber'] .' name="id[]"><span class="slider"></span></label>',
         "PONumber"=>'<a href="../po-detail/index.php?link='.$row['PONumber'].'" class="orderRef_" id='.$row['PONumber'].'>'.$row['PONumber'].'</a>',
         "Picker"=>$pker,
         "VendorName"=>$row['VendorName'],
         "Reference"=>$row['Reference'],
         "OrderValue"=>$row['OrderValue'],
         "OrderCreatedOn"=>$dateToBeInserted,
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