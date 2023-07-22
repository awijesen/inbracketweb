<?php
header("Cache-Control: no-cache");
include(__DIR__ . '/../../dbconnect/db.php');

$sql = "DELETE FROM INB_PICKFACE_STOCK";
$stmt = $conn->prepare($sql);
// $stmt->bind_param("s", $tobeDeleted);
$stmt->execute();
$result = $stmt->affected_rows;

if($result > 0) {
    echo "pfdeleted";
    exit;
} else {
    echo "nildeleted";
    exit;
}
?>

