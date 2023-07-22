<?php
session_start();
header("Cache-Control: no-cache");

require(__DIR__ . '../../../dbconnect/db.php');

$sql = "SELECT count(distinct(ProductCode)) as 'c' FROM INB_STOCKTAKE_SNAPSHOT
UNION ALL
SELECT count(distinct(ProductCode)) as 'c' FROM INB_STOCKTAKE_MASTER_DUMP
UNION ALL
select
sum(distinct(d.StocktakeCount) * s.LastCost) as 'c'
FROM INB_STOCKTAKE_MASTER_DUMP d
left outer join INB_STOCKTAKE_SNAPSHOT s on s.ProductCode=d.ProductCode
UNION ALL
select sum(StockSnapshot*LastCost) as 'c'
from
(
select StockSnapshot, LastCost, ProductCode, max(distinct(StockSnapshot)*LastCost) as MaxScore
from INB_STOCKTAKE_SNAPSHOT
group by ProductCode
) as t";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if (mysqli_num_rows($result) > 0) {
  while ($row = $result->fetch_assoc()) {
    $record = $row["c"];
    $response[] = array("data"=>$record);
    
  }
  echo json_encode($response);
 
} else {
  echo "error";
}
