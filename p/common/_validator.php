<?php

session_start();
require(__DIR__ . '/../../dbconnect/db.php');

$sql = "SELECT SessionID FROM INB_USERMASTER WHERE UserCode='".$_SESSION['UCODE']."'";
$qry = $conn->query($sql);
foreach($qry as $row){
    if($_SESSION['SSID'] != $row['SessionID']) {
        // echo "Id is : " . $row['SessionID'];
        // echo "session is : " . $_SESSION['SSID'];
        $data['output'] = 'logout';
    } else {
        $data['output'] = 'login';
    }
}

echo json_encode($data);