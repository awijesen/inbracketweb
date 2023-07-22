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
      $searchQuery = " AND (pk.SalesOrderNumber LIKE :SalesOrderNumber OR 
           ord.OrderCustomer LIKE :OrderCustomer OR
           pk.PickedBy LIKE :PickedBy OR 
           ord.ShipDay LIKE :ShipDay OR 
           pk.PushedBy LIKE :PushedBy OR
           pk.Reference LIKE :Reference ) ";
      $searchArray = array( 
           'SalesOrderNumber'=>"%$searchValue%",
           'OrderCustomer'=>"%$searchValue%",
           'PickedBy'=>"%$searchValue%",
           'ShipDay'=>"%$searchValue%",
           'PushedBy'=>"%$searchValue%",
           'Reference'=>"%$searchValue%" );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(pk.SalesOrderNumber)) as 'allcount' FROM INB_COMPLETED_PICKS pk WHERE pk.PushedStatus = 'Pushed' AND pk.InvoiceState IS NULL");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(pk.SalesOrderNumber)) as 'allcount' 
   FROM INB_COMPLETED_PICKS pk
   LEFT OUTER JOIN GRW_INB_SALES_ORDERS ord ON ord.SalesOrderNumber=pk.SalesOrderNumber
   WHERE pk.PushedStatus = 'Pushed' AND pk.InvoiceState IS NULL ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT
   pk.SalesOrderNumber,
   pk.PickedBy,
   pk.PickedOn,
   pk.PickStatus,
   pk.PushedTime,
   pk.PushedBy,
   pk.PushedStatus,
   ord.OrderCustomer,
   ord.ShipDay,
   pk.Reference,
   ord.CustomerGroupId
   FROM INB_COMPLETED_PICKS pk
   LEFT OUTER JOIN GRW_INB_SALES_ORDERS ord ON ord.SalesOrderNumber=pk.SalesOrderNumber
   WHERE pk.PushedStatus = 'Pushed' AND pk.InvoiceState IS NULL ".$searchQuery." 
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
  
      $row["CustomerGroupId"] === '11' ? $notes_ = "<span class='badge badge-soft-primary'>+7 Days</span>" : $notes_ = "";

      $data[] = array(
        //  "selector"=>'<label class="switch"><input type="checkbox" value='. $row['SalesOrderNumber'] .' name="id[]"><span class="slider"></span></label>',
         "SalesOrderNumber"=>'<a href="../_line_detail/index.php?link='.$row['SalesOrderNumber'].'" class="orderRef_" rel="noopener noreferrer" id='.$row['SalesOrderNumber'].'>'.$row['SalesOrderNumber'].'</a>',
         "PrintDocket"=>'<a href="../delivery_docket/index.php?linked='.$row['SalesOrderNumber'].'" target="_blank" class="orderRef_" id='.$row['SalesOrderNumber'].'><i class="fa-solid fa-print"></i></a>',
         "PickedBy"=>$row['PickedBy'],
         "PickedOn"=>$row['PickedOn'],
         "PickStatus"=>$row['PickStatus'],
         "PushedStatus"=>$row["PushedStatus"],
         "PushedTime"=>$row['PushedTime'],
         "PushedBy"=>$row['PushedBy'],
         "OrderCustomer"=>$row['OrderCustomer'],
         "ShipDay"=>$row['ShipDay'],
         "Reference"=>$row['Reference'],
         "Notes"=>$notes_
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