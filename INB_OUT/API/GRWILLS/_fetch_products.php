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
    CURLOPT_URL => 'https://remote.grwills.com.au:443/WebAPI/API/DB/CustomQuery?key=IWS_Products',
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
      $id_ = $response_new['ID'];
      $id = $response_new['ID'];
      $productcode = $response_new['ProductCode'];
      $productdescription = $response_new['ProductDescription'];
      $productgroup = $response_new['Group'];
      $uom = $response_new['A'];
      $barcode = $response_new['Barcode'];
      $sortcode = $response_new['SortCode'];
      $pricing1 = $response_new['OBS'];
      $pricing2 = $response_new['Alpa'];
      $pricing3 = $response_new['Normal'];
      $pricing4 = $response_new['Staff'];
      $pricing5 = $response_new['Wholesale'];
      $pricing6 = $response_new['CEQ'];
      $ERPStock = $response_new['Quantity'];
      $LastCost = $response_new['LastCost'];
      $Vendor = $response_new['SupplierName'];
      $VendorProductCode = $response_new['SupplierProductId'];
      $UoMId = $response_new["UnitOfMeasureId"];
      $ProductId = $response_new["ProductId"];

      if($response_new['Active'] === true) {
        $active = '1';
      } else {
        $active = '0';
      }
      

      $sql = "INSERT INTO INB_PRODUCT_MASTER (
        ID,
        UniqueId,
        ProductCode,
        ProductDescription,
        CustomFieldOne,
        UOM,
        Barcode,
        CustomFieldTwo,
        Pricing_One,
        Pricing_Tow,
        Pricing_Three,
        Pricing_Four,
        Pricing_Five,
        Pricing_Six,
        ERPStock,
        LastCost,
        Active,
        Vendor,
        VendorProductCode,
        ProductId,
        UOMID
        )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE 
    ProductCode = VALUES(ProductCode), 
    ProductDescription = VALUES(ProductDescription),
    CustomFieldOne = VALUES(CustomFieldOne),
    UOM = VALUES(UOM),
    Barcode = VALUES(Barcode),
    CustomFieldTwo = VALUES(CustomFieldTwo),
    Pricing_One = VALUES(Pricing_One),
    Pricing_Tow = VALUES(Pricing_Tow),
    Pricing_Three = VALUES(Pricing_Three),
    Pricing_Four = VALUES(Pricing_Four),
    Pricing_Five = VALUES(Pricing_Five),
    Pricing_Six = VALUES(Pricing_Six),
    ERPStock = VALUES(ERPStock),
    LastCost = VALUES(LastCost),
    Active = VALUES(Active),
    Vendor = VALUES(Vendor),
    VendorProductCode = VALUES(VendorProductCode),
    ProductId = VALUES(ProductId),
    UOMID = VALUES(UOMID)";
    
      $stmt = $conn->prepare($sql);
      $stmt->bind_param(
        'sssssssssssssssssssss',
        $id_,
        $id,
        $productcode,
        $productdescription,
        $productgroup,
        $uom,
        $barcode,
        $sortcode,
        $pricing1,
        $pricing2,
        $pricing3,
        $pricing4,
        $pricing5,
        $pricing6,
        $ERPStock,
        $LastCost,
        $active,
        $Vendor,
        $VendorProductCode,
        $ProductId,
        $UoMId
      );


      $status = $stmt->execute();
    }

    // $result = $stmt->get_result();
    if ($status === true) {
      //success
      echo "ProductsLoaded";
      
      // require('./_alterrecord.php');

      //insert close
    } else {
      echo "Error inserting products";
    }

    //incset code

  } else {
    require(__DIR__.'/NewToken/_bearer.php');
  }
  //-----
} else {
  $Response = 'doesnotexist';
  echo $Response;
}
