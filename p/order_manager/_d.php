<?php
session_start();
$tobeDeleted = htmlspecialchars($_POST['sotodel'] ?? '');
$pickerSelected = htmlspecialchars($_POST['_upkr'] ?? '');

include(__DIR__ . '/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime = date("Y-m-d h:i:s", time());

$failed_query = array(); // create an empty array to get which query fails
$failed_count = 0; // count to come to know how many query failed
$success_count = 0;

require('../../dbconnect/db.php');

if ($pickerSelected == 'DEL' && !isset($_POST['id'])) {
    echo "No order selected";
    exit;
} else if ($pickerSelected == 'DEL' && isset($_POST['id'])) {
    //start
    include(__DIR__ . '/../../dbconnect/db.php');

    foreach ($_POST['id'] as $key => $id) {

        $stmt = $conn->prepare("DELETE FROM GRW_INB_SALES_ORDERS WHERE SalesOrderNumber=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows !== 0) {
            
            $sqlc = "DELETE FROM GRW_INB_ASSIGNED_ORDERS WHERE SalesOrderNumber=?";
            $stmtc = $conn->prepare($sqlc);
            $stmtc->bind_param("s", $id);
            $stmtc->execute();
            $resultc = $stmtc->affected_rows;

            if ($resultc > 0) {
                $success_count++;
            } else {
                $failed_count++; // increase failed counter
                $failed_query[] = $resultt;
            }
        } else {
            $failed_count++; // increase failed counter
            $failed_query[] = $resultt;
        }
        //add

    }

    if ($success_count > 0 && $failed_count > 0) {
        echo $success_count . " order(s) delete and " . $failed_count . " failed";
    } else if ($success_count > 0 && $failed_count == 0) {
        echo $success_count . " order(s) deleted";
    } else if ($success_count == 0 && $failed_count > 0) {
        echo $failed_count . " order deletion(s) failed";
    }
}
