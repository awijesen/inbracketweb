<?php
session_start();

if($_SESSION["ROLE"] == 'local_manager' || $_SESSION["ROLE"] == 'super_admin') {
    
$tobeDeleted = htmlspecialchars($_POST['usrx'] ?? '');

include(__DIR__.'/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d h:i:s", time());

require('../../dbconnect/db.php');

$sql = "DELETE FROM INB_USERMASTER WHERE UserCode=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tobeDeleted);
$stmt->execute();
$result = $stmt->affected_rows;

if($result > 0) {
    echo "deleted";
} else {
    echo "error_";
}
} else {
    echo "nopreviledges";
}
