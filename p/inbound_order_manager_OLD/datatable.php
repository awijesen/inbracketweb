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
           ord.VendorName LIKE :VendorName ) ";
      $searchArray = array( 
           'PONumber'=>"%$searchValue%",
           'VendorName'=>"%$searchValue%" );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(DISTINCT(ord.PONumber)) AS allcount 
   FROM INB_PURCHASE_ORDERS ord");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(DISTINCT(ord.PONumber)) AS allcount 
   FROM INB_PURCHASE_ORDERS ord
   WHERE 1 ".$searchQuery);
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
   ord.CreatedBy
   FROM INB_PURCHASE_ORDERS ord
   WHERE 1 ".$searchQuery." 
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
  
    //   $row["Picker"] == '' || $row['Picker'] == null || $row['Picker'] == 'Schedule'? $pker = "<span class='badge' style='background-color: var(--falcon-blue)'>Schedule</span>" : $pker = "<span class='badge' style='background-color: var(--falcon-green); min-width: 62px !important'>".$row["Picker"]."</span>";

      $data[] = array(
        //  "selector"=>'<label class="switch"><input type="checkbox" value='. $row['SalesOrderNumber'] .' name="id[]"><span class="slider"></span></label>',
         // "PurchaseOrderNumber"=>'<a href="../picks_in_progress_detail/index.php?link='.$row['PurchaseOrderNumber'].'" class="orderRef_" id='.$row['PurchaseOrderNumber'].'>'.$row['PurchaseOrderNumber'].'</a>',
         "selector"=>'<label class="switch"><input type="checkbox" value='. $row['PONumber'] .' name="id[]"><span class="slider"></span></label>',
         "PurchaseOrderNumber"=>'<a href="../po-detail/index.php?link='.$row['PONumber'].'" class="orderRef_" id='.$row['PONumber'].'>'.$row['PONumber'].'</a>',
         "Picker"=>$pker,
         "VendorName"=>$row['VendorName'],
         "Reference"=>$row['Reference'],
         "OrderValue"=>$row['OrderValue'],
         "OrderCreatedOn"=>'asdad',
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