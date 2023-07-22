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
      $searchQuery = " AND (t.ProductCode LIKE :ProductCode OR 
           p.ProductDescription LIKE :ProductDescription OR
           t.ChangeReason LIKE :ChangeReason OR 
           t.ChangedBy LIKE :ChangedBy ) ";
      $searchArray = array( 
           'ProductCode'=>"%$searchValue%",
           'ProductDescription'=>"%$searchValue%",
           'ChangeReason'=>"%$searchValue%",
           'ChangedBy'=>"%$searchValue%" );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(t.ProductCode)) as 'allcount' FROM INB_STOCK_CORRECTION_TRAIL t");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(t.ProductCode)) as 'allcount' 
   FROM INB_STOCK_CORRECTION_TRAIL t 
   LEFT OUTER JOIN INB_PRODUCT_MASTER p on p.ProductCode=t.ProductCode
   WHERE 1  ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT
   t.ID,
   t.ProductCode,
   p.ProductDescription,
   t.ChangedQty,
   t.UnitPrice,
   cast((t.ChangedQty * t.UnitPrice) as decimal(20,2)) as 'ChangedValue',
   case
   when t.ChangeReason = 'CY' then 'Cyclecount stock adjustment'
   when t.ChangeReason = 'WR' then 'Write off'
   when t.ChangeReason = 'DM' then 'Damged stock'
   when t.ChangeReason = 'EX' then 'Expired stock'
   when t.ChangeReason = 'DN' then 'Donation'
   when t.ChangeReason = 'VC' then 'Vendor claim'
   when t.ChangeReason = 'ST' then 'Staff use'
   when t.ChangeReason = 'LR' then'[System]Line removed on a pick task'
   else ''
   end as 'Changereason',
   t.ChangeNotes,
   t.ChangedOn,
   t.ChangedBy
   FROM INB_STOCK_CORRECTION_TRAIL t
   LEFT OUTER JOIN INB_PRODUCT_MASTER p on p.ProductCode=t.ProductCode
   WHERE 1 ".$searchQuery."
   GROUP BY t.ID
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
      $dateToBeInserted = date('d-m-Y h:i a', strtotime($row['ChangedOn']));

    //   $row["Picker"] == '' || $row['Picker'] == null || $row['Picker'] == 'Schedule'? $pker = "<span class='badge' style='background-color: var(--falcon-blue)'>Schedule</span>" : $pker = "<span class='badge' style='background-color: var(--falcon-green); min-width: 62px !important'>".$row["Picker"]."</span>";

      $data[] = array(
        //  "selector"=>'<label class="switch"><input type="checkbox" value='. $row['SalesOrderNumber'] .' name="id[]"><span class="slider"></span></label>',
         // "SalesOrderNumber"=>'<a href="../invoice_history_details/index.php?link='.$row['SalesOrderNumber'].'" rel="noopener noreferrer" id='.$row['SalesOrderNumber'].'>'.$row['SalesOrderNumber'].'</a>',
         // "PrintDocket"=>'<a href="../delivery_docket/index.php?linked='.$row['SalesOrderNumber'].'" target="_blank" class="orderRef_" id='.$row['SalesOrderNumber'].'><i class="fa-solid fa-print"></i></a>',
         // "SalesOrderNumber"=>$row['SalesOrderNumber'],
         "ProductCode"=>$row['ProductCode'],
         "ProductDescription"=>$row['ProductDescription'],
         "ChangedQty"=>$row["ChangedQty"],
         "UnitPrice"=>$row["UnitPrice"],
         "ChangedValue"=>$row["ChangedValue"],
         "Changereason"=>$row["Changereason"],
         "ChangedOn"=>$dateToBeInserted ,
         "ChangedBy"=>$row["ChangedBy"],
         "ChangeNotes"=>$row["ChangeNotes"]
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