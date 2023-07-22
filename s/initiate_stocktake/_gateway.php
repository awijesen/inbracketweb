<?php
include(__DIR__ . '/../../dbconnect/db.php');

$stmtz = $conn->prepare("SELECT * FROM INB_STOCKTAKE_SNAPSHOT");
// $stmtz->bind_param("s", $id);
$stmtz->execute();
$resultz = $stmtz->get_result();
if ($resultz->num_rows === 0) {
    echo "unavailable";
} else {
    echo "available";
}