<?php
session_start();
$packid = htmlspecialchars($_POST['packid'] ?? '');
$transport = htmlspecialchars($_POST['transport'] ?? '');
$connote = htmlspecialchars($_POST['connote'] ?? '');
$palcount = htmlspecialchars($_POST['palcount'] ?? '');
$boxcount = htmlspecialchars($_POST['boxcount'] ?? '');
$footnote = htmlspecialchars($_POST['footnote'] ?? '');

include(__DIR__.'/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d h:i:s", time());

if($packid == 'selectpackinglist'){
    echo "Select packing list";
} else if($transport == 'selectcourier') {
    echo "Courier company required";
} else if($connote == '' || strlen($connote) < 2) {
    echo "Invalid consignment note";
} else if($palcount == '') {
    echo "Pallet count required";
} else if(!is_numeric($palcount)) {
    echo "Invalid pallet count";
} else if($boxcount == '') {
    echo "Box count required";
} else if(!is_numeric($boxcount)) {
    echo "Invalid box count";
} else {

require('../../dbconnect/db.php');

$sql = "UPDATE INB_PACK_LIST_DETAIL SET PalletCount=?, BoxCount=?, Courier=?, ConsignmentNote=?, FootNote=? WHERE packListId=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iissss", $palcount, $boxcount, $transport, $connote, $footnote, $packid);
$stmt->execute();
$result = $stmt->affected_rows;

if($result > 0) {
    echo "updated";
    exit;
} else {
    echo "error_";
    exit;
}

}
?>

