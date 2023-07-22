<?php
header("Cache-Control: no-cache");

    require(__DIR__ . '../../../dbconnect/db.php');
    $sql = "SELECT
    count(pf.ProductCode) as 'count'
    FROM INB_PICKFACE_STOCK pf 
    WHERE PickfaceStock < 0
    GROUP BY pf.ProductCode";

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
    