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
      $searchQuery = " AND (r.PurchaseOrderNumber LIKE :PurchaseOrderNumber OR 
           r.VendorName LIKE :VendorName OR
           r.AssignedBy LIKE :AssignedBy ) ";
      $searchArray = array( 
           'PurchaseOrderNumber'=>"%$searchValue%",
           'VendorName'=>"%$searchValue%",
           'AssignedBy'=>"%$searchValue%" );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(c.PurchaseOrderNumber)) as 'allcount' FROM INB_ASSIGNED_PURCHASE_ORDERS c");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(r.PurchaseOrderNumber)) as 'allcount' 
   FROM INB_ASSIGNED_PURCHASE_ORDERS r 
   LEFT OUTER JOIN INB_PURCHASE_RECEIPTS rp on rp.PONumber=r.PurchaseOrderNumber AND rp.ProductCode=r.ProductCode
   WHERE r.PurchaseOrderNumber IS NOT NULL ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT
   r.PurchaseOrderNumber,
   count(distinct(r.ProductCode)) as 'numoflines',
   count(distinct(rp.ProductCode)) as 'reclines',
   r.VendorName,
   r.AssignedBy,
   r.AssignedOn,
   r.Receiver
   FROM INB_ASSIGNED_PURCHASE_ORDERS r
   LEFT OUTER JOIN INB_PURCHASE_RECEIPTS rp on rp.PONumber=r.PurchaseOrderNumber AND rp.ProductCode=r.ProductCode
   WHERE r.PurchaseOrderNumber IS NOT NULL ".$searchQuery." 
   GROUP BY r.PurchaseOrderNumber
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
  
      $row["Receiver"] == '' || $row['Receiver'] == null || $row['Receiver'] == 'Schedule'? $pker = "<span class='badge' style='background-color: var(--falcon-blue)'></span>" : $pker = "<span class='badge' style='background-color: var(--falcon-green); min-width: 62px !important'>".$row["Receiver"]."</span>";

      $data[] = array(
        //  "selector"=>'<label class="switch"><input type="checkbox" value='. $row['SalesOrderNumber'] .' name="id[]"><span class="slider"></span></label>',
         "PurchaseOrderNumber"=>'<a href="../receipts_in_progress_detail/index.php?link='.$row['PurchaseOrderNumber'].'" class="orderRef_" id='.$row['PurchaseOrderNumber'].'>'.$row['PurchaseOrderNumber'].'</a>',
         // "PurchaseOrderNumber"=>$row["PurchaseOrderNumber"],
         "numoflines"=>$row['numoflines'],
         "reclines"=>$row['reclines'],
         "VendorName"=>$row['VendorName'],
         "AssignedBy"=>$row['AssignedBy'],
         "AssignedOn"=>$row['AssignedOn'],
         "Receiver"=>$pker
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