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
      $searchQuery = " AND (ProductCode LIKE :ProductCode OR 
           ProductDescription LIKE :ProductDescription OR
           Barcode LIKE :Barcode OR 
           CustomFieldOne LIKE :CustomFieldOne OR 
           CustomFieldTwo LIKE :CustomFieldTwo ) ";
      $searchArray = array( 
           'ProductCode'=>"%$searchValue%",
           'ProductDescription'=>"%$searchValue%",
           'Barcode'=>"%$searchValue%",
           'CustomFieldOne'=>"%$searchValue%",
           'CustomFieldTwo'=>"%$searchValue%" );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(ProductCode)) as 'allcount' FROM INB_PRODUCT_MASTER");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(distinct(ProductCode)) as 'allcount' 
   FROM INB_PRODUCT_MASTER
   WHERE 1 ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT
   ProductCode,
   ProductDescription,
   Barcode,
   CustomFieldOne as 'Group',
   CustomFieldTwo as 'SortDesc',
   Active,
   UOM, 
   format(Pricing_One,2) as 'OBS',
   format(Pricing_Tow, 2) as 'ALPA',
   format(Pricing_Six,2) as 'CEQ',
   format(Pricing_Five,2) as 'Wholesale',
   format(Pricing_Four,2) as 'Staff'
   FROM INB_PRODUCT_MASTER
   WHERE 1 ".$searchQuery."
   GROUP BY ProductCode
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
      if ($row["Active"] === '1') {
         $entry = "<span class='badge badge-soft-success' style='min-width: 62px !important'>Active</span>";
       } else {
         $entry = "<span class='badge badge-soft-danger' style='min-width: 62px !important'>Inactive</span>";
       }
    //   $row["Picker"] == '' || $row['Picker'] == null || $row['Picker'] == 'Schedule'? $pker = "<span class='badge' style='background-color: var(--falcon-blue)'>Schedule</span>" : $pker = "<span class='badge' style='background-color: var(--falcon-green); min-width: 62px !important'>".$row["Picker"]."</span>";

      $data[] = array(
        //  "selector"=>'<label class="switch"><input type="checkbox" value='. $row['SalesOrderNumber'] .' name="id[]"><span class="slider"></span></label>',
         // "SalesOrderNumber"=>'<a href="../_line_detail/index.php?link='.$row['SalesOrderNumber'].'" class="orderRef_" rel="noopener noreferrer" id='.$row['SalesOrderNumber'].'>'.$row['SalesOrderNumber'].'</a>',
         // "PrintDocket"=>'<a href="../delivery_docket/index.php?linked='.$row['SalesOrderNumber'].'" target="_blank" class="orderRef_" id='.$row['SalesOrderNumber'].'><i class="fa-solid fa-print"></i></a>',
         "ProductCode"=>$row['ProductCode'],
         "ProductDescription"=>$row['ProductDescription'],
         "Barcode"=>$row['Barcode'],
         "Group"=>$row["Group"],
         "SortDesc"=>$row['SortDesc'],
         "Active"=> $entry,
         "UOM"=>$row['UOM'],
         "OBS"=>$row['OBS'],
         "ALPA"=>$row['ALPA'],
         "Wholesale"=>$row['Wholesale'],
         "CEQ"=>$row['CEQ'],
         "Staff"=>$row['Staff']
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