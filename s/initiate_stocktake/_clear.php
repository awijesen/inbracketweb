<?php
$tobeDeleted = htmlspecialchars($_POST['snd'] ?? '');

include(__DIR__ . '/../../dbconnect/db.php');

$sql = "DELETE FROM INB_STOCKTAKE_SNAPSHOT WHERE StocktakeID=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tobeDeleted);
$stmt->execute();
$result = $stmt->affected_rows;

if($result > 0) {
    echo "deleted";
    exit;
} else {
    echo "error_";
    exit;
}
?>

