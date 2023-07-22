<?php
session_start();

$order = htmlspecialchars($_POST["order"] ?? '');
$quantity = htmlspecialchars($_POST["quantity"] ?? '');
$customer = htmlspecialchars($_POST["customer"] ?? '');
$reference = htmlspecialchars($_POST["reference"] ?? '');
$uom = htmlspecialchars($_POST["uom"] ?? '');
$assignedon = htmlspecialchars($_POST["assignedon"] ?? '');
$pcode = 'FAKLOBS';
$desc = 'Outback Stores FETCH order';
$user = htmlspecialchars($_POST["picker"] ?? '');;
$assignedby =  $_SESSION['UCODE'];
$shipday = htmlspecialchars($_POST["shipday"] ?? '');

include(__DIR__ . '/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime = date("Y-m-d h:i:s", time());


if ($order == '') {
    echo "Invalid sales order";
    exit;
} else {
    include(__DIR__ . '/../../dbconnect/db.php');


    $stmt = $conn->prepare("SELECT * FROM GRW_INB_ASSIGNED_ORDERS ord WHERE ord.SalesOrderNumber=? AND ProductCode='FAKLOBS'");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        //add
        $stmt = $conn->prepare("INSERT INTO GRW_INB_ASSIGNED_ORDERS (
                            SalesOrderNumber,
                            ProductCode,
                            ProductDescription,
                            OrderQuantity,
                            Picker,
                            AssignedBy,
                            AssignedOn,
                            OrderCustomer,
                            Reference,
                            ShipDay,
                            UOM) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssisssssss', $order, $pcode, $desc, $quantity, $user, $assignedby, $actualtime, $customer, $reference, $shipday, $uom);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            echo "Assign Failed!";
        } else {
            echo "success";
            // $success_count++;
        }
        $stmt->close();
        //add close
    } else {
        //delete and insert again
        $stmt = $conn->prepare("DELETE FROM GRW_INB_ASSIGNED_ORDERS WHERE SalesOrderNumber = ? AND ProductCode='FAKLOBS'");
        $stmt->bind_param("s", $order);
        $stmt->execute();
        if ($stmt->affected_rows !== 0) {
            //re-insert
            $stmt = $conn->prepare("INSERT INTO GRW_INB_ASSIGNED_ORDERS (
                    SalesOrderNumber,
                    ProductCode,
                    ProductDescription,
                    OrderQuantity,
                    Picker,
                    AssignedBy,
                    AssignedOn,
                    OrderCustomer,
                    Reference,
                    ShipDay,
                    UOM) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssisssssss', $order, $pcode, $desc, $quantity, $user, $assignedby, $actualtime, $customer, $reference, $shipday, $uom);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                echo "Assign Failed!";
            } else {
                echo "success-";
                // $success_count++;
            }
            $stmt->close();

            //re-insert close
        } else {
            echo "Error Deleting ";
        }
        $stmt->close();
    }


    // foreach ($resultt as $key => $val) {
    //     echo $val;
    //  }
    // echo "Failed queries are <br/>";
    // echo "<pre/>";print_r($failed_query);
}
