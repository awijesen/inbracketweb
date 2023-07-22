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
      $searchQuery = " AND (r.PONumber LIKE :PONumber OR 
            r.VendorName LIKE :VendorName OR
            r.Reference LIKE :Reference OR
            r.CreatedBy LIKE :CreatedBy OR
            (SELECT distinct(ass.Receiver) FROM INB_ASSIGNED_PURCHASE_ORDERS ass WHERE ass.PurchaseOrderNumber=r.PONumber) LIKE :Receiver ) ";
      $searchArray = array( 
           'PONumber'=>"%$searchValue%",
           'VendorName'=>"%$searchValue%",
           'Reference'=>"%$searchValue%",
           'CreatedBy'=>"%$searchValue%",
           'Receiver'=>"%$searchValue%" );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(c.PONumber)) as 'allcount' FROM INB_PURCHASE_ORDERS c");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(r.PONumber)) as 'allcount' 
   FROM INB_PURCHASE_ORDERS r 
   LEFT OUTER JOIN INB_PURCHASE_RECEIPTS rp on rp.PONumber=r.PONumber AND rp.ProductCode=r.ProductCode
   WHERE r.PONumber IS NOT NULL AND r.PONumber NOT IN(SELECT rr.PONumber FROM INB_PURCHASE_RECEIPTS rr) 
   AND r.PONumber NOT IN(SELECT k.PurchaseOrderNumber from INB_COMPLETED_PURCHASE_RECEIPTS k)".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT
   r.PONumber,
   r.VendorName,
   r.Reference,
   r.OrderValue,
   r.OrderCreatedOn,
   r.CreatedBy,
   (SELECT distinct(ass.Receiver) FROM INB_ASSIGNED_PURCHASE_ORDERS ass WHERE ass.PurchaseOrderNumber=r.PONumber) as 'Receiver'
   FROM INB_PURCHASE_ORDERS r
   LEFT OUTER JOIN INB_PURCHASE_RECEIPTS rp on rp.PONumber=r.PONumber AND rp.ProductCode=r.ProductCode
   WHERE r.PONumber IS NOT NULL 
   AND r.PONumber NOT IN(SELECT rr.PONumber FROM INB_PURCHASE_RECEIPTS rr)
   AND r.PONumber NOT IN(SELECT k.PurchaseOrderNumber from INB_COMPLETED_PURCHASE_RECEIPTS k)".$searchQuery." 
   GROUP BY r.PONumber
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
  
      $row["Receiver"] == '' || $row['Receiver'] == null || $row['Receiver'] == 'Schedule'? $pker = "<span class='badge badge-soft-primary'>Schedule</span>" : 
      $pker = "<span class='badge' style='background-color: var(--falcon-btn-falcon-success-active-background); color: var(--falcon-list-group-item-color-success); min-width: 62px !important'>".$row["Receiver"]."</span>";;

      $data[] = array(
         "selector"=>'<label class="switch"><input type="checkbox" value='. $row['PONumber'] .' name="id[]"><span class="slider"></span></label>',
         "PONumber"=>'<a href="../po-detail/index.php?link='.$row['PONumber'].'" class="orderRef_" id='.$row['PONumber'].'>'.$row['PONumber'].'</a>',
         // "PONumber"=>$row["PONumber"],
         "VendorName"=>$row['VendorName'],
         "Reference"=>$row["Reference"],
         "OrderValue"=>$row["OrderValue"],
         "OrderCreatedOn"=>$row["OrderCreatedOn"],
         "CreatedBy"=>$row["CreatedBy"],
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