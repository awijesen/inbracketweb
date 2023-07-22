<?php
require(__DIR__ . '../../../dbconnect/db.php');

$sql = "SELECT distinct(ProductCode) as 'ProductCode', ProductDescription FROM INB_PRODUCT_MASTER ORDER BY ProductCode ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if (mysqli_num_rows($result) > 0) {
  while ($row = $result->fetch_assoc()) {
    echo '<option>'.$row["ProductCode"].'</option>';
  }
} else {
  echo "error";
}    ?>