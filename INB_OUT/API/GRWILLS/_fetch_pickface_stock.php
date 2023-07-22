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
        CURLOPT_URL => 'https://remote.grwills.com.au:443/WebAPI/API/DB/CustomQuery?key=IWS_PickfaceStock',
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
            $ProductCode = $response_new['ProductCode'];
            $Pickface = $response_new['Pickface'];
            $PickfaceStock = $response_new['PickfaceStock'];
            $WarehouseId = $response_new['WarehouseId'];

            $sql = "INSERT INTO INB_PICKFACE_STOCK (
                ProductCode,
                Pickface,
                PickfaceStock,
                WarehouseId) 
                    VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                ProductCode = VALUES(ProductCode), 
                Pickface = VALUES(Pickface),
                PickfaceStock = VALUES(PickfaceStock), 
                WarehouseId = VALUES(WarehouseId)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                'ssis',
                $ProductCode,
                $Pickface,
                $PickfaceStock,
                $WarehouseId
            );


            $status = $stmt->execute();
        }

        // $result = $stmt->get_result();
        if ($status === true) {
            //success
            echo "Pickfaces Loaded";

            // require('./_alterrecord.php');

            //insert close
        } else {
            echo "Error inserting pickface stock";
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
