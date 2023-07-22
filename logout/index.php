<?php
session_start();
// Redirect to the login page:
header('Location: ../');


require(__DIR__ . '/../dbconnect/db.php');

$sql = "SELECT SessionID FROM INB_USERMASTER WHERE UserCode='".$_SESSION['UCODE']."' AND tenent_id='".$_SESSION['TID']."'";
$qry = $conn->query($sql);
foreach($qry as $row){
    if($_SESSION['SSID'] == $row['SessionID']) {
        $uc = $_SESSION['UCODE'];
        $tid = $_SESSION['TID'];

        $sqlx = "UPDATE INB_USERMASTER SET IsLoggedIn=false, SessionID=null, LoginChannel=null WHERE UserCode=? AND tenent_id=?";
        $stmtx = $conn->prepare($sqlx);
        $stmtx->bind_param("ss", $uc, $tid);
        $stmtx->execute();
        $resultx = $stmtx->affected_rows;
        if($resultx > 0) {
        session_destroy();
        echo "success";
        }
    
    } else {
        echo "Error-Y6TFG";
    }
}

?>