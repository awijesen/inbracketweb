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
        CURLOPT_URL => 'https://remote.grwills.com.au:443/WebAPI/API/DB/CustomQuery?key=IWS_PurchaseReceived',
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
            $PONumber = $response_new['PO_NUM'];
            $Receiver = $response_new['RECEIVER'];
            $ProductCode = $response_new['PRODUCT_CODE'];
            $ProductDescription = $response_new['PRODUCT_DESC'];
            $ReceivedQuantity = $response_new['RECEIVED_QTY'];
            $ReasonCode = $response_new['REASON_CODE'];
            $PlateNumber = $response_new['PLATE_NO'];  
            $ReceiptStatus = $response_new['RECEIVAL_STATUS'];
            $ReceivedTimeStamp = $response_new['RECEIVED_TIMESTAMP'];
            $PutawayTimeStamp = $response_new['PA_COMPLETE_TIMESTAMP'];
            $PutawayUser = $response_new['PA_USER'];
            $PutawayQuantity = $response_new['PA_QTY'];
            $PutawayStatus = $response_new['PA_STATUS'];
            $LastPutawayQuantity = $response_new['LAST_PA_QTY'];
            $LastPutawayLocation = $response_new['LAST_PA_LOC'];
            $PutawayCompletedTimeStamp = $response_new['PA_COMPLETED_TIMESTAMP'];

            $sql = "INSERT INTO INB_PURCHASE_RECEIPTS (
                PONumber,
                Receiver,
                ProductCode,
                ProductDescription,
                ReceivedQuantity,
                ReasonCode,
                PlateNumber,
                ReceiptStatus,
                ReceivedTimeStamp,
                PutawayTimeStamp,
                PutawayUser,
                PutawayQuantity,
                PutawayStatus,
                LastPutawayQuantity,
                LastPutawayLocation,
                PutawayCompletedTimeStamp) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                'ssssissssssisiss',
                $PONumber,
                $Receiver,
                $ProductCode,
                $ProductDescription,
                $ReceivedQuantity,
                $ReasonCode,
                $PlateNumber,
                $ReceiptStatus,
                $ReceivedTimeStamp,
                $PutawayTimeStamp,
                $PutawayUser,
                $PutawayQuantity,
                $PutawayStatus,
                $LastPutawayQuantity,
                $LastPutawayLocation,
                $PutawayCompletedTimeStamp
            );


            $status = $stmt->execute();
        }

        // $result = $stmt->get_result();
        if ($status === true) {
            //success
            echo "Receipts Loaded";

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
