<?php
header("Cache-Control: no-cache");
$prodCode = $_POST["searchc"];
    require(__DIR__ . '../../../dbconnect/db.php');
    $sql = "SELECT Barcode FROM INB_PRODUCT_MASTER WHERE ProductCode=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $prodCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        
        while ($row = $result->fetch_assoc()) {
            $bc = $row["Barcode"];
            $response[] = array("bc"=>$bc);
        }
        echo json_encode($response);
    } else {
        echo "error";
    }    ?>