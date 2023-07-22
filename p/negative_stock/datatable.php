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
      $searchQuery = " AND (pf.ProductCode LIKE :ProductCode OR 
           pm.ProductDescription LIKE :ProductDescription OR
           pm.Barcode LIKE :Barcode OR 
           pf.PickfaceStock LIKE :PickfaceStock OR 
           pf.Pickface LIKE :Pickface ) ";
      $searchArray = array( 
           'ProductCode'=>"%$searchValue%",
           'ProductDescription'=>"%$searchValue%",
           'Barcode'=>"%$searchValue%",
           'PickfaceStock'=>"%$searchValue%",
           'Pickface'=>"%$searchValue%" );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(pf.ProductCode)) as 'allcount' FROM INB_PICKFACE_STOCK pf WHERE PickfaceStock < 0");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(pf.ProductCode)) as 'allcount' 
   FROM INB_PICKFACE_STOCK pf 
   LEFT OUTER JOIN INB_PRODUCT_MASTER pm ON pm.ProductCode=pf.ProductCode
   WHERE PickfaceStock < 0 ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT
   pf.ProductCode,
   pm.ProductDescription,
   pm.Barcode as 'Barcode',
   pf.PickfaceStock,
   pf.Pickface
   FROM INB_PICKFACE_STOCK pf 
   LEFT OUTER JOIN INB_PRODUCT_MASTER pm ON pm.ProductCode=pf.ProductCode
   WHERE PickfaceStock < 0 ".$searchQuery."
   GROUP BY pm.ProductCode 
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
         // "SalesOrderNumber"=>'<a href="../_line_detail/index.php?link='.$row['SalesOrderNumber'].'" class="orderRef_" rel="noopener noreferrer" id='.$row['SalesOrderNumber'].'>'.$row['SalesOrderNumber'].'</a>',
         // "PrintDocket"=>'<a href="../delivery_docket/index.php?linked='.$row['SalesOrderNumber'].'" target="_blank" class="orderRef_" id='.$row['SalesOrderNumber'].'><i class="fa-solid fa-print"></i></a>',
         "ProductCode"=>$row['ProductCode'],
         "ProductDescription"=>$row['ProductDescription'],
         "Barcode"=>$row['Barcode'],
         "PickfaceStock"=>$row["PickfaceStock"],
         "Pickface"=>$row['Pickface']
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