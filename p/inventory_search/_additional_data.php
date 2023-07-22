<?php
$code = htmlspecialchars($_POST["prodCode"] ?? '');

require('../../dbconnect/db.php');

$sql = "SELECT pf.Pickface, m.ProductDescription FROM INB_PRODUCT_MASTER m
LEFT OUTER JOIN INB_PICKFACE_STOCK pf on pf.ProductCode=m.ProductCode
WHERE m.ProductCode=?
GROUP BY m.ProductDescription";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $code);
$stmt->execute();
$result = $stmt->get_result();

if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
    $pc = $row["Pickface"];
    $bc = $row["ProductDescription"];
    $response = array("pickface_"=>$pc, "description_"=>$bc);
    }
  echo json_encode($response);

} else {
    $response = array("Alert_"=>"   ");
    echo json_encode($response);
}    
