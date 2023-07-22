<?php
session_start();

    require(__DIR__ . '../../../dbconnect/db.php');

$sql = "SELECT format(count(distinct(ProductCode)), '#,#') as 'TotValue' FROM INB_STOCKTAKE_SNAPSHOT
union all
select format(round(sum(StockSnapshot*LastCost),2), '#,#') as 'TotValue'
from
(
select StockSnapshot, LastCost, ProductCode, max(StockSnapshot*LastCost) as MaxScore
from INB_STOCKTAKE_SNAPSHOT
group by ProductCode
) as t";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if (mysqli_num_rows($result) > 0) {
  while ($row = $result->fetch_assoc()) {
    $record = $row["TotValue"];
    $response[] = array("rec"=>$record);
    
  }
  echo json_encode($response);
 
} else {
  echo "error";
}
