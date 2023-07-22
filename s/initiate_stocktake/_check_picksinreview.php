<?php
header("Cache-Control: no-cache");

    require(__DIR__ . '../../../dbconnect/db.php');
    $sql = "SELECT
    count(pk.SalesOrderNumber) as 'count'
    FROM INB_COMPLETED_PICKS pk
    WHERE pk.PushedStatus IS NULL
    GROUP BY pk.SalesOrderNumber";

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
    