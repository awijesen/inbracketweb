<?php
session_start();
$tobeUpdated = htmlspecialchars($_POST['usrx'] ?? '');
$stat = '1';

include(__DIR__.'/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d h:i:s", time());

require('../../dbconnect/db.php');

$stmt = $conn->prepare("SELECT ActiveStatus FROM INB_USERMASTER WHERE UserCode = ? and ActiveStatus=?"); 
    // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
    $stmt->bind_param('ss', $tobeUpdated, $stat);
    $stmt->execute();
    $stmt->store_result();
    // Store the result so we can check if the account exists in the database.
    if ($stmt->num_rows > 0) {
        echo "User alreay active";
    } else{

$sql = "UPDATE INB_USERMASTER SET ActiveStatus='1' WHERE UserCode=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tobeUpdated);
$stmt->execute();
$result = $stmt->affected_rows;

if($result > 0) {
    echo "Success!";
    exit;
} else {
    echo "Error. Unable to locate the user";
    exit;
}
    }
?>

