<?php
session_start();

date_default_timezone_set('Australia/Darwin');
$actualtime = date("Y-m-d h:i:s", time());
$statuscheck = 'Active';
$select = htmlspecialchars($_POST["sel"]);

$mode = 'On';
$user = $_SESSION['UCODE'];

require(__DIR__ . '../../../dbconnect/db.php');

    $sql = "UPDATE INB_USERMASTER set StockTakeMode=?, SessionID=null WHERE UserCode != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        'ss',
        $mode,
        $user
    );

    $status = $stmt->execute();
    if ($status) {    

        $sqlx = "UPDATE INB_STOCKTAKE_SNAPSHOT set StockTakeStatus = ? WHERE  StocktakeID = ?";
        $stmtx = $conn->prepare($sqlx);
        $stmtx->bind_param(
            'ss',
            $statuscheck,
            $select
        );

    $statusx = $stmtx->execute();
    if ($statusx) {
        echo "active";
    } else {
        echo "error - HJKIE27";
    }

    } else {
        echo "Error - UABSTK3";
    }

