<?php

$cust_ = $_POST['customer'];

?>
    <?php
    require(__DIR__ . '../../../dbconnect/db.php');
    $sql = "SELECT distinct(SalesOrderNumber) FROM GRW_INB_ASSIGNED_ORDERS WHERE OrderCustomer=? GROUP BY SalesOrderNumber";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cust_);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            $lst .= '<option value=' . $row["SalesOrderNumber"] . '>' . $row["SalesOrderNumber"] . '</option>';
        }
        echo $lst;
    } else {
        echo "error";
    }    ?>

