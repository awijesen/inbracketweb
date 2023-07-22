<?php
include('../dbconnect/db.php');

$curl = curl_init();

$headers = [
    "Authorization: Bearer s-txtVdwxi8p6tCbwqrmhCzihLs8YXpVgNoeK8knlBjU2Ihy4b8SPpv1RMJjDEvIfe5XCSJgp7rGZidYkPpLKzzclROXOspJIvYzuNhcFEnNygRdojq3elO12TEw1DhCmIZCC_NvE_WV9er9qv4b6bbTOfyvUN0dAlUAJKFSWm93XJWVAKffEJ0g3gN0wZbsSsEGr4YPFr3beWP_rJbsolXlZtoA0j5BOkHgBtQJZci4Ynlz5UnUhsTh16SgDZb0Yv3Q1dzhYR7thyTb_gMqNULHHu85zvJEo9-p2kpfzQTrkAiUlwiRhT_Bimd-noHOO3uJZdKcUVZPy0V4RO1o4V7Pb7bI-W_zn_Fjvm0AV3qzB9jyyqAMQZPJ-3yrIo4_yuydowNFdtKSbIl7_qVtL8DcSxjqFCXGqFegbA_wcCIbSvEMmJaCom8eDBka6SK6UqBLiDrqUmkK0n4BjtF6m_vdT2d8dhV7Y4tU6sCsP22eyEPpZTgRNW0sEEEw1PrbEpG92AX4RIU2P9FRR4qli7K7FGyZF8-vfZwY6388fXU-6JLtlKEWHLgqw1Aex1czZpbxHM3Bn6gjBthNg_oPWOQCi_9SPlaFIyowL4rlgSsthqkklrJ5guKNLP4oLSyACtHcguV9ErqjcdPBO-HkCj68X6sz7wUV6Y01dlP2b0n6LJR20i3rjrbfn94q-_H8cQjjUNu_4oaHsOmV7Wn9uoB7-io6cvqrjufaYOP0mdZSsFCupmHAoo7zMttVj9JTZMwqKQCpKeDi2q-XRGrKWx98mV6fJC2TA3Gcg85rXf5pGeh7GS3QerCaNT_z0_SzkIyZ0DlpimMMT8LXmPxJFfl89x4LpLimluzZKF7JdiPUhWLTVrauESvqf0fSl0pXmhL76bi3YxE7intb1FigLP8cqj3AA2arlVzazJkztC2jqE5T12GK2D7Bl3OI0YKliHaCJVJq6U2JSh9-trD-PI5pZNAQLfu7x6T7P_3t1aWDY0ItCS2B4Gd8aWBz21ZR6N37QQNjyksp9-YvtE5T_J6Vn9tWPI4pTgTUuIaAuT58h7dNkEBIVsHYIXoY013Z"
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
    CURLOPT_POSTFIELDS => 'grant_type=password&database=G&RWillsVision&username=MohanW&password=G&RWills90',
));

$filename = curl_exec($curl);

$status_code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);


if (curl_errno($curl)) {
    echo 'Error:' . curl_error($curl);
  }   
  curl_close($curl);

  if($status_code == '401'){
      echo "Auth failed";
  } else {

$array = json_decode($filename, true);

foreach ($array as $row) {
    echo $row;


    $sql = "SELECT LineId FROM INB_SALES_ORDERS WHERE LineId=?"; // SQL with parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $row['LineId']);
    $stmt->execute();
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) > 0) {
    } else {


        if ($stmt = $conn->prepare('INSERT INTO INB_SALES_ORDERS (LineId, OrderSegmentId, SalesOrderNumber, OrderCustomerName, OrderReference, OrderProcessedDate, OrderShipDay, OrderCreatedBy, TotalOrderValue, ProductCode, ProductDescription, OrderQty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE
          OrderSegmentId = VALUES(OrderSegmentId)
        , SalesOrderNumber = VALUES(SalesOrderNumber)
        , OrderCustomerName = VALUES(OrderCustomerName)
        , OrderReference = VALUES(OrderReference)
        , OrderProcessedDate = VALUES(OrderProcessedDate)
        , OrderShipDay = VALUES(OrderShipDay)
        , OrderCreatedBy = VALUES(OrderCreatedBy)
        , TotalOrderValue = VALUES(TotalOrderValue)
        , ProductCode = VALUES(ProductCode)
        , ProductDescription = VALUES(ProductDescription)
        , OrderQty = VALUES(OrderQty)')) {
            // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
            $stmt->bind_param("ssssssssissi", $row['LineId'], $row['SortCodeDescription'], $row['SO'], $row['Customer'], $row['Reference'], $row['ProcessedDate'], $row['Shipday'], $row['createdby'], $row['value'], $row['Code'], $row['Description'], $row['OrdQty']);
            $stmt->execute();
            if ($stmt->execute()) {
                $response = 'You have successfully registered';
                echo $response;
            } else {
                // $response = "Error!";
                $response = $stmt->error;
                echo $response;
            }
        } else {
            // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
            echo 'Could not prepare statement!';
            die;
        }
        // echo $response;
    }
}

  
$stmt->close();
$conn->close();

  }

?>
