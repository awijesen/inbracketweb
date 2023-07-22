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
      $searchQuery = " AND (p.SalesOrderNumber LIKE :SalesOrderNumber OR 
           p.OrderCustomer LIKE :OrderCustomer OR
           p.InvoicedBy LIKE :InvoicedBy OR 
           p.InvoicedOn LIKE :InvoicedOn OR
           p.Reference LIKE :Reference ) ";
      $searchArray = array( 
           'SalesOrderNumber'=>"%$searchValue%",
           'OrderCustomer'=>"%$searchValue%",
           'InvoicedBy'=>"%$searchValue%",
           'InvoicedOn'=>"%$searchValue%",
           'Reference'=>"%$searchValue%" );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(p.SalesOrderNumber)) as 'allcount' FROM INB_COMPLETED_PICKS p 
   LEFT JOIN INB_INVOICES_TEMP t on t.SalesOrderNumber=p.SalesOrderNumber
   where p.InvoiceState='Invoiced'");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(p.SalesOrderNumber)) as 'allcount' 
   FROM INB_COMPLETED_PICKS p
   LEFT JOIN INB_INVOICES_TEMP t on t.SalesOrderNumber=p.SalesOrderNumber
   where p.InvoiceState='Invoiced' ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT 
   p.SalesOrderNumber,
   p.OrderCustomer,
   p.InvoiceState,
   p.InvoicedBy,
   p.InvoicedOn,
   t.InvoiceNumber,
   p.Reference,
   p.ShipDay
   FROM INB_COMPLETED_PICKS p
   LEFT JOIN INB_INVOICES_TEMP t on t.SalesOrderNumber=p.SalesOrderNumber
   WHERE p.InvoiceState='Invoiced' ".$searchQuery."
   GROUP BY p.SalesOrderNumber
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
      $dateToBeInserted = date('d-m-Y h:i a', strtotime($row['InvoicedOn']));

      $row["InvoiceNumber"] == '' ? $flag = "" : $flag = "<i style='color: var(--falcon-green)' class='fa-solid fa-circle-check'></i>";

      $data[] = array(
         "SalesOrderNumber"=>'<a href="../invoice_history_details/index.php?link='.$row['SalesOrderNumber'].'" rel="noopener noreferrer" id='.$row['SalesOrderNumber'].'>'.$row['SalesOrderNumber'].'</a>',
         "OrderCustomer"=>$row['OrderCustomer'],
         "InvoiceState"=>"<span class='badge' style='background-color: var(--falcon-btn-falcon-success-active-background); color: var(--falcon-list-group-item-color-success); min-width: 62px !important'>".$row['InvoiceState']."</span>",
         "InvoicedBy"=>$row["InvoicedBy"],
         "InvoicedOn"=>$dateToBeInserted,
         "InvoiceNumber"=>$row["InvoiceNumber"],
         "shipday"=>$row["ShipDay"],
         "Reference"=>$row["Reference"],
         "erpStatus"=>$flag 
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