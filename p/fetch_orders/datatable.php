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
      $searchQuery = " AND (ls.StockPlate LIKE :StockPlate OR 
           ls.CustomerName LIKE :CustomerName OR
           ls.DespatchedStatus LIKE :DespatchedStatus OR 
           ls.ShipDay LIKE :ShipDay OR
           ls.DeliveryInstructions LIKE :DeliveryInstructions ) ";
      $searchArray = array( 
           'StockPlate'=>"%$searchValue%",
           'CustomerName'=>"%$searchValue%",
           'DespatchedStatus'=>"%$searchValue%",
           'ShipDay'=>"%$searchValue%",
           'DeliveryInstructions'=>"%$searchValue%" );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(ls.StockPlate)) as 'allcount' FROM INB_FETCH_ORDERS_LIST ls");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(ls.StockPlate)) as 'allcount' FROM INB_FETCH_ORDERS_LIST ls
   WHERE 1 ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT
   ls.ID,
   ls.CustomerId as 'FetchID',
   ls.StockPlate,
   ls.CustomerName,
   ls.DateReceived,
   ls.ReceivedQty,
   ls.DespatchedStatus,
   ls.ShipDay,
   ls.DeliveryInstructions,
   ord.SalesOrderNumber,
   ord.Picker,
   ord.OrderCustomer,
   ord.Reference,
   ord.UOM,
   ls.TaggedOrder as 'assigned_status'
   FROM INB_FETCH_ORDERS_LIST ls
	LEFT OUTER JOIN GRW_INB_ASSIGNED_ORDERS ord on ord.OrderCustomer=ls.CustomerName
   WHERE 1 ".$searchQuery." 
   GROUP BY ls.StockPlate
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
  
      $row["assigned_status"] != '' ? $assigned_status="<span class='badge' style='background-color: var(--falcon-blue)'>Assigned to ".$row['assigned_status']. " <i class='fa-sharp fa-solid fa-check'></i></span>" : $assigned_status=null;
      $out = strlen($row['DeliveryInstructions']) > 30 ? substr($row['DeliveryInstructions'],0,30)."..." : $row['DeliveryInstructions'];
      $dateToBeInserted = date('d-m-Y h:i a', strtotime($row['DateReceived']));
      $row["SalesOrderNumber"] != '' ? $order_exists="<span class='badge' style='background-color: var(--falcon-blue)'>Available</span>" : $order_exists="";
      $row['DespatchedStatus'] == 'Pending' ? $dstatus="<span class='badge' style='background-color: var(--falcon-warning)'>Pending</span>" : $dstatus="";

      $row["SalesOrderNumber"] != '' ? $stat="Y" : $stat="N";

      $data[] = array(
        //  "selector"=>'<label class="switch"><input type="checkbox" value='. $row['SalesOrderNumber'] .' name="id[]"><span class="slider"></span></label>',
         // "SalesOrderNumber"=>'<a href="../_line_detail/index.php?link='.$row['SalesOrderNumber'].'" class="orderRef_" id='.$row['SalesOrderNumber'].'>'.$row['SalesOrderNumber'].'</a>',
         "FetchID"=>$row['FetchID'],
         "StockPlate"=>$row['StockPlate'],
         "CustomerName"=>$row['CustomerName'],
         "DateReceived"=>$dateToBeInserted,
         "ReceivedQty"=>$row['ReceivedQty'],
         "DespatchedStatus"=>$dstatus,
         "ShipDay"=>$row['ShipDay'],
         "DeliveryInstructions"=>$out,
         "order_exists" => $order_exists,
         "assigned_status"=> $assigned_status,
         "ActionButton" => "<a href='#' 
            class='assign_ft_order' 
            id='".$row['ID']."' 
            qty='".$row['ReceivedQty']."' 
            so_status='".$stat."' 
            order_num='".$row['SalesOrderNumber']."'
            cust='".$row['OrderCustomer']."'
            refer='".$row['Reference']."'
            uom='".$row['UOM']."'
            picker='".$row['Picker']."'
            shipday='".$row['ShipDay']."'
            assignedorder='".$row['assigned_status']."'
            ><i class='fas fa-plus-square'></i></a>"

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