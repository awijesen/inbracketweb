<?php
session_start();

$assignedorderexists = htmlspecialchars($_POST["assignedorderexists"] ?? '');
$id = htmlspecialchars($_POST["id"] ?? '');
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

if ($assignedorderexists != '') {
    // echo "exiting record";
    // echo $assignedorderexists;
    // exit;
    include(__DIR__ . '/../../dbconnect/db.php');
    $sql = "DELETE FROM GRW_INB_ASSIGNED_ORDERS WHERE SalesOrderNumber=? AND ProductCode='FAKLOBS'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $assignedorderexists);
    $stmt->execute();
    $result = $stmt->affected_rows;

    // if ($result > 0) {
        include(__DIR__ . '/../../dbconnect/db.php');
        $sqlax = "UPDATE INB_FETCH_ORDERS_LIST SET TaggedOrder='' WHERE TaggedOrder=? AND ID=?";
        $stmtax = $conn->prepare($sqlax);
        $stmtax->bind_param("si", $assignedorderexists, $id);
        $stmtax->execute();

        $resultax = $stmtax->affected_rows;

        if ($resultax > 0) {
            include(__DIR__ . '/../../dbconnect/db.php');


            $stmt = $conn->prepare("SELECT * FROM GRW_INB_ASSIGNED_ORDERS ord WHERE ord.SalesOrderNumber=? AND ProductCode='FAKLOBS'");
            $stmt->bind_param("s", $order);
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
                    $sqla = "UPDATE INB_FETCH_ORDERS_LIST SET TaggedOrder=? WHERE ID=?";
                    $stmta = $conn->prepare($sqla);
                    $stmta->bind_param("si", $order, $id);
                    $stmta->execute();

                    $resulta = $stmta->affected_rows;

                    if ($resulta > 0) {
                        echo "success-";
                        exit;
                    } else {
                        echo "error - HJWT34";
                        exit;
                    }
                }
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
                        $sqla = "UPDATE INB_FETCH_ORDERS_LIST SET TaggedOrder=? WHERE ID=?";
                        $stmta = $conn->prepare($sqla);
                        $stmta->bind_param("si", $order, $id);
                        $stmta->execute();

                        $resulta = $stmta->affected_rows;

                        if ($resulta > 0) {
                            echo "success-";
                        } else {
                            echo "error - HJWT35";
                        }
                        // $success_count++;
                    }

                    //re-insert close
                } else {
                    echo "Error Deleting ";
                }
            }
        } else {
            echo "Error 1";
        }
    // } else {
    //     echo "non deleted";
    // }
} else {
    // echo "does not exit";
    // echo $assignedorderexists;
    // exit;
    include(__DIR__ . '/../../dbconnect/db.php');


    $stmt = $conn->prepare("SELECT * FROM GRW_INB_ASSIGNED_ORDERS ord WHERE ord.SalesOrderNumber=? AND ProductCode='FAKLOBS'");
    $stmt->bind_param("s", $order);
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
            $sqla = "UPDATE INB_FETCH_ORDERS_LIST SET TaggedOrder=? WHERE ID=?";
            $stmta = $conn->prepare($sqla);
            $stmta->bind_param("si", $order, $id);
            $stmta->execute();

            $resulta = $stmta->affected_rows;

            if ($resulta > 0) {
                echo "success-";
                exit;
            } else {
                echo "error - HJWT34";
                exit;
            }
        }
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
                $sqla = "UPDATE INB_FETCH_ORDERS_LIST SET TaggedOrder=? WHERE ID=?";
                $stmta = $conn->prepare($sqla);
                $stmta->bind_param("si", $order, $id);
                $stmta->execute();

                $resulta = $stmta->affected_rows;

                if ($resulta > 0) {
                    echo "success-";
                } else {
                    echo "error - HJWT35";
                }
                // $success_count++;
            }

            //re-insert close
        } else {
            echo "Error Deleting ";
        }
    }
}

