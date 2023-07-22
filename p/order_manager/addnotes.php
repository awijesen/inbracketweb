<?php
ini_set('session.cookie_domain', '.inbracket.com');
session_start();

$pickerSelected = htmlspecialchars($_POST['_upkr'] ?? '');
$order_notes = htmlspecialchars($_POST['tVal'] ?? '');

include(__DIR__ . '/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime = date("Y-m-d h:i:s", time());

$failed_query = array(); // create an empty array to get which query fails
$failed_count = 0; // count to come to know how many query failed
$success_count = 0;

if (isset($_POST['id'])) {
    include(__DIR__ . '/../../dbconnect/db.php');

    foreach ($_POST['id'] as $key => $id) {

        $stmt = $conn->prepare("SELECT * FROM GRW_INB_SALES_ORDERS ORDF WHERE ORDF.SalesOrderNumber=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows !== 0) {
            //add
            $stmtc = $conn->prepare("UPDATE GRW_INB_SALES_ORDERS SET OrderNotes=? WHERE SalesOrderNumber=?");
            $stmtc->bind_param("ss", $order_notes, $id);
            $stmtc->execute();

            $resultc = $stmtc->get_result();
            if ($resultc->num_rows === 0) {
                echo "Assign Failed!";
            } else {
                // echo "success";
                $success_count++;
            }
            $stmt->close();
            //add close
        } else {
            //do
            $stmtx = $conn->prepare("DELETE OrderNotes FROM GRW_INB_SALES_ORDERS WHERE SalesOrderNumber = ?");
            $stmtx->bind_param("s", $id);
            $stmtx->execute();
            if ($stmtx->affected_rows !== 0) {
                //re-insert
                $stmtq = $conn->prepare("UPDATE GRW_INB_SALES_ORDERS SET OrderNotes=? WHERE SalesOrderNumber=?");
            $stmtq->bind_param("ss", $order_notes, $id);
            $stmtq->execute();

            $resultq = $stmtq->get_result();
            if ($resultq->num_rows === 0) {
                echo "Assign Failed!";
            } else {
                // echo "success";
                $success_count++;
            }
                //re-insert close
            } else {
                echo "Error Deleting ";
            }
            $stmtx->close();
            $failed_count++; // increase failed counter
            $failed_query[] = $resultt;
        }


        // foreach ($resultt as $key => $val) {
        //     echo $val;
        //  }
        // echo "Failed queries are <br/>";
        // echo "<pre/>";print_r($failed_query);
    }
    if ($success_count > 0 && $failed_count > 0) {
        echo $success_count . " order(s) assigned and " . $failed_count . " updated";
    } else if ($success_count > 0 && $failed_count == 0) {
        echo $success_count . " order(s) assigned";
    } else if ($success_count == 0 && $failed_count > 0) {
        echo $failed_count . " order(s) updated";
    }
} else {
    echo "No orders selected";
}
