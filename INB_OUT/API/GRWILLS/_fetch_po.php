<?php
header("Cache-Control: no-cache");

require(__DIR__ . '../../../../dbconnect/db.php');

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
        CURLOPT_URL => 'https://remote.grwills.com.au:443/WebAPI/API/DB/CustomQuery?key=IWS_PO',
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
            $PONumber = $response_new['PurchaseOrderNumber'];
            $ProductCode = $response_new['Code'];
            $ProductDescription = $response_new['Description'];
            $OrdedrQuantity = $response_new['BaseQuantityOrdered'];
            $VendorName = $response_new['OrderSupplierName'];
            $TransactionDate = $response_new['TransactionDate'];
            $UnitOfMeasureDescription = $response_new['UnitOfMeasureDescription'];
            $PurchaseOrderLineId = $response_new['PurchaseOrderLineId'];
            $Reference = $response_new['Reference'];
            $OrderValue = $response_new['Total'];
            $CreatedBy = $response_new['CreatedBy'];


            $sql = "INSERT INTO INB_PURCHASE_ORDERS (
                PONumber,
                ProductCode,
                ProductDescription,
                OrderQuantity,
                VendorName,
                OrderCreatedOn,
                UOM,
                UniqueId,
                Reference,
                OrderValue,
                CreatedBy) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE 
                    PONumber = VALUES(PONumber), 
                    ProductCode = VALUES(ProductCode), 
                    ProductDescription = VALUES(ProductDescription),
                    OrderQuantity = VALUES(OrderQuantity),
                    VendorName = VALUES(VendorName),
                    OrderCreatedOn = VALUES(OrderCreatedOn),
                    UOM = VALUES(UOM),
                    UniqueId = VALUES(UniqueId),
                    Reference = VALUES(Reference),
                    OrderValue = VALUES(OrderValue),
                    CreatedBy = VALUES(CreatedBy)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                'sssisssssis',
                $PONumber,
                $ProductCode,
                $ProductDescription,
                $OrdedrQuantity,
                $VendorName,
                $TransactionDate,
                $UnitOfMeasureDescription,
                $PurchaseOrderLineId,
                $Reference,
                $OrderValue,
                $CreatedBy
            );


            $status = $stmt->execute();
        }

        // $result = $stmt->get_result();
        if ($status === true) {
            //success
            echo "Purchase Orders Loaded";

            // require('./_alterrecord.php');

            //insert close
        } else {
            echo "Error inserting receipts data";
        }

        //incset code

    } else {
        require(__DIR__ . '/NewToken/_bearer_so.php');
    }
    //-----
} else {
    $Response = 'doesnotexist';
    echo $Response;
}
