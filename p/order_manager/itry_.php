<?php
ini_set('session.cookie_domain', '.inbracket.com' );
session_start();

$pickerSelected = htmlspecialchars($_POST['_upkr'] ?? '');
$reason_codesx = htmlspecialchars($_POST['reason_hidden'] ?? '');

include(__DIR__.'/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d h:i:s", time());

$failed_query = array(); // create an empty array to get which query fails
$failed_count = 0; // count to come to know how many query failed
$success_count = 0;

if (!isset($pickerSelected) || $pickerSelected == 'selectpicker') {
    echo "Select picker";
    exit;
} else if ($pickerSelected == 'HOLD' && !isset($_POST['id'])) {
    echo "No order selected";
    exit;
} else if($pickerSelected == 'HOLD' && isset($_POST['id'])) {
//start
include(__DIR__.'/../../dbconnect/db.php');

foreach ($_POST['id'] as $key => $id) {

    $stmt = $conn->prepare("SELECT * FROM GRW_INB_SALES_ORDERS ORDF WHERE ORDF.SalesOrderNumber=? 
    AND NOT EXISTS(SELECT distinct(ORD.SalesOrderNumber) FROM GRW_INB_ASSIGNED_ORDERS ORD WHERE ORD.SalesOrderNumber=ORDF.SalesOrderNumber)");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows !== 0) {
        //add
        $stmt = $conn->prepare("INSERT INTO GRW_INB_ASSIGNED_ORDERS (SalesOrderNumber, ProductCode, ProductDescription, OrderQuantity, Picker, AssignedBy, OrderCustomer, Reference, AssignedOn, ShipDay, UOM, Notes, OnHoldReason, CustomerGroupId, OrderCustomerId)
                    SELECT SalesOrderNumber, 
                    ProductCode, 
                    ProductDescription, 
                    OrderQuantity, 
                    '".$pickerSelected."', 
                    '".$_SESSION['UCODE']."',
                    OrderCustomer,
                    Reference,
                    '".$actualtime."',
                    ShipDay,
                    UOM,
                    Notes,
                    '".$reason_codesx."',
                    CustomerGroupId,
                    OrderCustomerId
                    FROM GRW_INB_SALES_ORDERS WHERE SalesOrderNumber=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            echo "Assign Failed!";
        } else {
            // echo "success";
            $success_count++;
        }
        $stmt->close();
        //add close
    } else {
        //delete and insert again
        $stmt = $conn->prepare("DELETE FROM GRW_INB_ASSIGNED_ORDERS WHERE SalesOrderNumber = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        if($stmt->affected_rows !== 0) {
            //re-insert
            $stmt = $conn->prepare("INSERT INTO GRW_INB_ASSIGNED_ORDERS (SalesOrderNumber, ProductCode, ProductDescription, OrderQuantity, Picker, AssignedBy, OrderCustomer, Reference, AssignedOn, ShipDay, UOM, Notes, OnHoldReason, CustomerGroupId, OrderCustomerId)
            SELECT SalesOrderNumber, 
            ProductCode, 
            ProductDescription, 
            OrderQuantity, 
            '".$pickerSelected."', 
            '".$_SESSION['UCODE']."',
            OrderCustomer,
            Reference,
            '".$actualtime."',
            ShipDay,
            UOM,
            Notes,
            '".$reason_codesx."',
            CustomerGroupId,
            OrderCustomerId
            FROM GRW_INB_SALES_ORDERS WHERE SalesOrderNumber=?");
            $stmt->bind_param("s", $id);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                // echo "Action Failed";
            } else {
                // echo "Reassigned! ";
            }

            //re-insert close
        } else {
            echo "Error Deleting ";
        }
        $stmt->close();
        $failed_count++; // increase failed counter
        $failed_query[] = $resultt;
    }

       
        // foreach ($resultt as $key => $val) {
        //     echo $val;
        //  }
        // echo "Failed queries are <br/>";
        // echo "<pre/>";print_r($failed_query);
}
if($success_count > 0 && $failed_count > 0) {
    echo $success_count." order(s) on hold and ".$failed_count." updated";
} else if($success_count > 0 && $failed_count == 0) {
    echo $success_count." order(s) on hold";
} else if($success_count == 0 && $failed_count > 0){
    echo $failed_count." order(s) updated";
}
//end

} else if (isset($_POST['id'])) {
    include(__DIR__.'/../../dbconnect/db.php');

    foreach ($_POST['id'] as $key => $id) {

        $stmt = $conn->prepare("SELECT * FROM GRW_INB_SALES_ORDERS ORDF WHERE ORDF.SalesOrderNumber=? 
        AND NOT EXISTS(SELECT distinct(ORD.SalesOrderNumber) FROM GRW_INB_ASSIGNED_ORDERS ORD WHERE ORD.SalesOrderNumber=ORDF.SalesOrderNumber)");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows !== 0) {
            //add
            $stmt = $conn->prepare("INSERT INTO GRW_INB_ASSIGNED_ORDERS (SalesOrderNumber, ProductCode, ProductDescription, OrderQuantity, Picker, AssignedBy, OrderCustomer, Reference, AssignedOn, ShipDay, UOM, Notes, OnHoldReason, CustomerGroupId, CustomField1, OrderCustomerId)
                        SELECT SalesOrderNumber, 
                        ProductCode, 
                        ProductDescription, 
                        OrderQuantity, 
                        '".$pickerSelected."', 
                        '".$_SESSION['UCODE']."',
                        OrderCustomer,
                        Reference,
                        '".$actualtime."',
                        ShipDay,
                        UOM,
                        Notes,
                        null,
                        CustomerGroupId,
                        CustomField1,
                        OrderCustomerId
                        FROM GRW_INB_SALES_ORDERS WHERE SalesOrderNumber=?");
            $stmt->bind_param("s", $id);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                echo "Assign Failed!";
            } else {
                // echo "success";
                $success_count++;
            }
            $stmt->close();
            //add close
        } else {
            //delete and insert again
            $stmt = $conn->prepare("DELETE FROM GRW_INB_ASSIGNED_ORDERS WHERE SalesOrderNumber = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            if($stmt->affected_rows !== 0) {
                //re-insert
                $stmt = $conn->prepare("INSERT INTO GRW_INB_ASSIGNED_ORDERS (SalesOrderNumber, ProductCode, ProductDescription, OrderQuantity, Picker, AssignedBy, OrderCustomer, Reference, AssignedOn, ShipDay, UOM, Notes, OnHoldReason, CustomerGroupId, CustomField1, OrderCustomerId)
                SELECT SalesOrderNumber, 
                ProductCode, 
                ProductDescription, 
                OrderQuantity, 
                '".$pickerSelected."', 
                '".$_SESSION['UCODE']."',
                OrderCustomer,
                Reference,
                '".$actualtime."',
                ShipDay,
                UOM,
                Notes,
                null,
                CustomerGroupId,
                CustomField1,
                OrderCustomerId
                FROM GRW_INB_SALES_ORDERS WHERE SalesOrderNumber=?");
                $stmt->bind_param("s", $id);
                $stmt->execute();

                $result = $stmt->get_result();
                if ($result->num_rows === 0) {
                    // echo "Action Failed";
                } else {
                    // echo "Reassigned! ";
                }

                //re-insert close
            } else {
                echo "Error Deleting ";
            }
            $stmt->close();
            $failed_count++; // increase failed counter
            $failed_query[] = $resultt;
        }

           
            // foreach ($resultt as $key => $val) {
            //     echo $val;
            //  }
            // echo "Failed queries are <br/>";
            // echo "<pre/>";print_r($failed_query);
    }
    if($success_count > 0 && $failed_count > 0) {
        echo $success_count." order(s) assigned and ".$failed_count." updated";
    } else if($success_count > 0 && $failed_count == 0) {
        echo $success_count." order(s) assigned";
    } else if($success_count == 0 && $failed_count > 0){
        echo $failed_count." order(s) updated";
    }
    
} else {
    echo "No orders selected";
}