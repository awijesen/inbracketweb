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
        CURLOPT_URL => 'https://remote.grwills.com.au:443/WebAPI/API/DB/CustomQuery?key=IWS_Fetch',
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
            $CustomerId = $response_new['CustomerId'];
            $Name = $response_new['Name'];
            $ShipDay = $response_new['ShipDay'];
            $DeliveryInstructions = $response_new['DeliveryInstructions'];
            $PostalStreet = $response_new['PostalStreet'];
            $PostalState = $response_new['PostalState'];
            $PostalPostCode = $response_new['PostalPostCode'];
            $OBSFetchCode = $response_new['OBSFetchCode'];


            $sql = "INSERT INTO INB_FETCH_ORDERS (
        CustomerId, 
        CustomerName,
        ShipDay, 
        DeliveryInstructions,
        PostalStreet,
        PostalState,
        PostalPostCode,
        OBSFetchCode
        )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE 
    CustomerId = VALUES(CustomerId), 
    CustomerName = VALUES(CustomerName),
    ShipDay = VALUES(ShipDay), 
    DeliveryInstructions = VALUES(DeliveryInstructions),
    PostalStreet = VALUES(PostalStreet),
    PostalState = VALUES(PostalState),
    PostalPostCode = VALUES(PostalPostCode),
    OBSFetchCode = VALUES(OBSFetchCode)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                'ssssssss',
                $CustomerId,
                $Name,
                $ShipDay,
                $DeliveryInstructions,
                $PostalStreet,
                $PostalState,
                $PostalPostCode,
                $OBSFetchCode
            );


            $status = $stmt->execute();
        }

        // $result = $stmt->get_result();
        if ($status === true) {
            //success
            echo "Fetch orders loaded";

            // require('./_alterrecord.php');

            //insert close
        } else {
            echo "Error inserting fetch orders";
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
