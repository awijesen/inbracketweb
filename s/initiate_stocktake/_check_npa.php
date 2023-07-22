<?php
header("Cache-Control: no-cache");

    require(__DIR__ . '../../../dbconnect/db.php');
    $sql = "SELECT
    count(ProductCode) as 'count'
    from INB_PURCHASE_RECEIPTS
    WHERE PutawayStatus = 'InProgress' 
    OR PutawayStatus IS NULL 
    and ReceivedQuantity > 0 
    and STR_TO_DATE(ReceivedTimeStamp, '%Y-%m-%d') > '2022-12-01'";

    $stmt = $conn->prepare($sql);
    // $stmt->bind_param("s", $cust_);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row['count'];    
        }
    } else {
        echo "0";
    }    
    