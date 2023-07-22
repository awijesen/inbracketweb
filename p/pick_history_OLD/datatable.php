<?php
date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d", time());
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
      $searchQuery = " AND (pk.SalesOrderNumber LIKE :SalesOrderNumber OR 
           pk.OrderCustomer LIKE :OrderCustomer OR
           pk.Reference LIKE :Reference OR
           PickedBy LIKE :PickedBy OR 
         --   ord.ShipDay LIKE :ShipDay OR 
           PickStatus LIKE :PickStatus ) ";
      $searchArray = array( 
           'SalesOrderNumber'=>"%$searchValue%",
           'Reference'=>"%$searchValue%",
           'OrderCustomer'=>"%$searchValue%",
           'PickedBy'=>"%$searchValue%",
         //   'ShipDay'=>"%$searchValue%",
           'PickStatus'=>"%$searchValue%" );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(pk.SalesOrderNumber)) as 'allcount' FROM INB_COMPLETED_PICKS pk WHERE pk.PushedStatus = 'Pushed'");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(pk.SalesOrderNumber)) as 'allcount' 
   FROM INB_COMPLETED_PICKS pk 
   LEFT OUTER JOIN GRW_INB_SALES_ORDERS ord on ord.SalesOrderNumber =pk.SalesOrderNumber
   WHERE pk.PushedStatus = 'Pushed' ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT
   pk.SalesOrderNumber,
   pk.PickedBy,
   pk.PickedOn,
   pk.PickStatus,
   pk.PushedStatus,
   pk.PushedTime,
   pk.Reference,
   pk.OrderCustomer
   FROM INB_COMPLETED_PICKS pk
   -- LEFT OUTER JOIN GRW_INB_SALES_ORDERS ord on ord.SalesOrderNumber =pk.SalesOrderNumber
   WHERE pk.PushedStatus = 'Pushed' ".$searchQuery." 
   GROUP BY pk.SalesOrderNumber
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
    $pickedon = date('d-m-Y h:i a', strtotime($row['PickedOn']));
    $pushedon = date('d-m-Y h:i a', strtotime($row['PushedTime']));

      $data[] = array(
         "PrintDocket"=>'<a href="../delivery_docket/index.php?linked='.$row['SalesOrderNumber'].'" target="_blank" rel="noopener noreferrer" class="orderRef_" id='.$row['SalesOrderNumber'].'><i class="fa-solid fa-print"></i></a>',
         "SalesOrderNumber"=>'<a href="../pick_details/index.php?link='.$row['SalesOrderNumber'].'" class="orderRef_" id='.$row['SalesOrderNumber'].'>'.$row['SalesOrderNumber'].'</a>',
         "PickedBy"=>$row['PickedBy'],
         "Reference"=>$row['Reference'],
         "PickedOn"=>$pickedon,
         "PickStatus"=>$row['PickStatus'],
         "PushedStatus"=>$row["PushedStatus"],
         "PushedTime"=>$pushedon,
         "OrderCustomer"=>$row['OrderCustomer'],
         "ShipDay"=>$row['ShipDay']
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