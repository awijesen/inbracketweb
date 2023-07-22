<?php
$searchId = htmlspecialchars($_POST["packid"] ?? '');

if($searchId == '' || $searchId == null){
    $response = array("Alert_"=>"No pack id");
    echo json_encode($response);
} else {
require(__DIR__ . '../../../dbconnect/db.php');

$sql = "SELECT PalletCount, BoxCount
FROM INB_PACK_LIST 
WHERE packListId=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $searchId);
$stmt->execute();
$result = $stmt->get_result();

if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
    $pc = $row["PalletCount"];
    $bc = $row["BoxCount"];
    $response = array("pc"=>$pc, "bc"=>$bc);
    }
  echo json_encode($response);

} else {
    $response = array("Alert_"=>"Error");
    echo json_encode($response);
}    
}
?>