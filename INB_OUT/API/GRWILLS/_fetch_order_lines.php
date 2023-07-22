<?php
header("Cache-Control: no-cache");

require(__DIR__.'../../../../dbconnect/db.php');

$sql = "SELECT INB_TOKEN FROM INB_CREDS";

$stmt = $conn->prepare($sql);
// $stmt->bind_param("s", $search);
// $search = $findOrder;
$stmt->execute();
$result = $stmt->get_result();

if (mysqli_num_rows($result) > 0) {
  while ($row = $result->fetch_assoc()) {
    $token = $row["INB_TOKEN"];
  }
  $curl = curl_init();

  $headers = [
    "Authorization: Bearer $token"
  ];
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://remote.grwills.com.au:443/WebAPI/API/DB/CustomQuery?key=IWS_SalesOrders',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_POSTFIELDS => 'grant_type=refresh_token&database=G&RWillsVision&username=MohanW&password=G&RWills90',
  ));

  $response = curl_exec($curl);

  $status_code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);

  curl_close($curl);

  if ($status_code === 200) {
    //insert

    $response_ = json_decode($response, true);
    
    foreach ($response_ as $response_new) {
      $LineId = $response_new['LineId'];
      $SortCodeDescription = $response_new['SortCodeDescription'];
      $SO = $response_new['SO'];
      $Customer = $response_new['Customer'];
      $Reference = $response_new['Reference'];
      $ProcessedDate = $response_new['ProcessedDate'];
      $CreatedOn = $response_new['CreatedOn'];
      $Shipday = $response_new['Shipday'];
      $createdby = $response_new['createdby'];
      $value = $response_new['value'];
      $Code = $response_new['Code'];
      $Description = $response_new['Description'];
      $OrdQty = $response_new['OrdQty'];
      $UnitOfMeasureDescription = $response_new['UnitOfMeasureDescription'];
      $Notes = $response_new['Notes'];
      $OrderCustomerId = $response_new['CustomerId'];
      $DeliveryInstructions = $response_new['DeliveryInstructions'];
      $InvoiceGuide = $response_new['GroupId'];
      $BarcodeReq = $response_new['bcreq'];

      $sql = "INSERT INTO GRW_INB_SALES_ORDERS (
        UniqueRef, 
        SalesOrderNumber,
        ProductCode, 
        ProductDescription,
        OrderQuantity,
        OrderCustomer,
        ProcessedDate,
        CreatedOn,
        CreatedBy,
        ShipDay,
        OrderValue,
        Reference,
        UOM,
        Notes,
        OrderCustomerId,
        DeliveryInstructions,
        SortCodeDescription,
        CustomerGroupId,
        CustomField1
        )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE 
        UniqueRef = VALUES(UniqueRef), 
        SalesOrderNumber = VALUES(SalesOrderNumber),
        ProductCode = VALUES(ProductCode), 
        ProductDescription = VALUES(ProductDescription),
        OrderQuantity = VALUES(OrderQuantity),
        OrderCustomer = VALUES(OrderCustomer),
        ProcessedDate = VALUES(ProcessedDate),
        CreatedOn = VALUES(CreatedOn),
        CreatedBy = VALUES(CreatedBy),
        ShipDay = VALUES(ShipDay),
        OrderValue = VALUES(OrderValue),
        Reference = VALUES(Reference),
        UOM = VALUES(UOM),
        Notes = VALUES(Notes),
        OrderCustomerId = VALUES(OrderCustomerId),
        DeliveryInstructions = VALUES(DeliveryInstructions),
        SortCodeDescription = VALUES(SortCodeDescription),
        CustomerGroupId = VALUES(CustomerGroupId),
        CustomField1 = VALUES(CustomField1)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param(
        'sssssssssssssssssss',
        $LineId,
        $SO,
        $Code,
        $Description,
        $OrdQty,
        $Customer,
        $ProcessedDate,
        $CreatedOn,
        $createdby,
        $Shipday,
        $value,
        $Reference,
        $UnitOfMeasureDescription,
        $Notes,
        $OrderCustomerId,
        $DeliveryInstructions,
        $SortCodeDescription,
        $InvoiceGuide,
        $BarcodeReq
      );


      $status = $stmt->execute();
    }

    // $result = $stmt->get_result();
    if ($status === true) {
      //success
      echo "Loaded";
      
      // require('./_alterrecord.php');

      //insert close
    } else {
      echo "Error inserting orders";
    }

    //incset code

  } else {
    require(__DIR__.'/NewToken/_bearer_so.php');
  }
  //-----
} else {
  $Response = 'doesnotexist';
  echo $Response;
}
