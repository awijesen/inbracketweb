<?php
session_start();
header("Cache-Control: no-cache");

    require(__DIR__ . '../../../dbconnect/db.php');

$sql = "SELECT 
fname,
lname,
UserCode,
case
when LoginChannelMobile = 1 then 'Active'
else '' end as 'OnMobile',
case 
when IsLoggedIn = 1 then 'Active'
else '' end as 'OnWeb'
from INB_USERMASTER
WHERE (IsLoggedIn=1 OR LoginChannelMobile=1) AND UserCode != '".$_SESSION['UCODE']."'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if (mysqli_num_rows($result) > 0) {
  while ($row = $result->fetch_assoc()) {
    $name = $row["fname"]." ".$row["lname"];
    $mob = $row["OnMobile"];
    $web = $row["OnWeb"];
    $response[] = array("name"=>$name, "mob"=>$mob, "web"=>$web);
    
  }
  echo json_encode($response);
 
} else {
  echo "0";
}
