<?php
session_start();

$pickerSelected = $_POST['_ureceiver'];

include(__DIR__ . '/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime = date("Y-m-d h:i:s", time());

$failed_query = array(); // create an empty array to get which query fails
$failed_count = 0; // count to come to know how many query failed
$success_count = 0;

if (!isset($pickerSelected) || $pickerSelected == 'selectpicker') {
    echo "Select receiver";
    exit;
} else if (isset($_POST['id'])) {
    include(__DIR__ . '/../../dbconnect/db.php');

    foreach ($_POST['id'] as $key => $id) {

        $stmt = $conn->prepare("SELECT * FROM INB_ASSIGNED_PURCHASE_ORDERS ord WHERE ord.PurchaseOrderNumber=?
        AND NOT EXISTS(SELECT distinct(R.PONumber) FROM INB_PURCHASE_RECEIPTS R WHERE R.PONumber=ord.PurchaseOrderNumber)");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        if ($result->num_rows === 0) {
            //add
            $stmt = $conn->prepare("INSERT INTO INB_ASSIGNED_PURCHASE_ORDERS (
                            PurchaseOrderId,
                            PurchaseOrderNumber,
                            ProductCode,
                            ProductId,
                            ProductDescription,
                            OrderQuantity,
                            Receiver,
                            AssignedBy,
                            AssignedOn,
                            VendorName,
                            UOM,
                            UniqueId
                        )
                        SELECT
                            null,
                            p.PONumber,
                            p.ProductCode,
                            null,
                            p.ProductDescription,
                            p.OrderQuantity,
                            '" . $pickerSelected . "',
                            '" . $_SESSION['UCODE'] . "',
                            '" . $actualtime . "',
                            p.VendorName,
                            p.UOM,
                            p.UniqueId
                            from INB_PURCHASE_ORDERS p
                            WHERE PONumber=?
                                ON DUPLICATE KEY UPDATE 
                                PurchaseOrderId = null,
                                PurchaseOrderNumber = p.PONumber,
                                ProductCode = p.ProductCode,
                                ProductId = null,
                                ProductDescription = p.ProductDescription,
                                OrderQuantity = p.OrderQuantity,
                                Receiver = '" . $pickerSelected . "',
                                AssignedBy = '" . $_SESSION['UCODE'] . "',
                                AssignedOn = '" . $actualtime . "',
                                VendorName = p.VendorName,
                                UOM = p.UOM,
                                UniqueId = p.UniqueId");
            $stmt->bind_param("s", $id);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                echo "Assign Failed!";
            } else {
                // echo "success";
                $stmtf = $conn->prepare("DELETE FROM INB_COMPLETED_PURCHASE_RECEIPTS WHERE PurchaseOrderNumber = ?");
                $stmtf->bind_param("s", $id);
                $stmtf->execute();
                if ($stmtf->affected_rows !== 0) {
                    $success_count++;
                }
            }
            $stmt->close();
            //add close
        } else {
            //delete and insert again
            $stmt = $conn->prepare("DELETE FROM INB_ASSIGNED_PURCHASE_ORDERS WHERE PurchaseOrderNumber = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            if ($stmt->affected_rows !== 0) {
                //re-insert
                $stmt = $conn->prepare("INSERT INTO INB_ASSIGNED_PURCHASE_ORDERS (
                    PurchaseOrderId,
                    PurchaseOrderNumber,
                    ProductCode,
                    ProductId,
                    ProductDescription,
                    OrderQuantity,
                    Receiver,
                    AssignedBy,
                    AssignedOn,
                    VendorName,
                    UOM,
                    UniqueId
                )
                SELECT
                    null,
                    PONumber,
                    ProductCode,
                    null,
                    ProductDescription,
                    OrderQuantity,
                    '" . $pickerSelected . "',
                    '" . $_SESSION['UCODE'] . "',
                    '" . $actualtime . "',
                    VendorName,
                    UOM,
                    UniqueId
                    from INB_PURCHASE_ORDERS
                    WHERE PONumber=?");
                $stmt->bind_param("s", $id);
                $stmt->execute();

                $result = $stmt->get_result();
                if ($result->num_rows === 0) {
                    // echo "Action Failed";
                } else {

                $stmtfx = $conn->prepare("DELETE FROM INB_COMPLETED_PURCHASE_RECEIPTS WHERE PurchaseOrderNumber = ?");
                $stmtfx->bind_param("s", $id);
                $stmtfx->execute();
                if ($stmtfx->affected_rows !== 0) {
                    echo "Reassigned! ";
                }

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
    if ($success_count > 0 && $failed_count > 0) {
        echo $success_count . " PO(s) assigned and " . $failed_count . " updated";
    } else if ($success_count > 0 && $failed_count == 0) {
        echo $success_count . " PO(s) assigned";
    } else if ($success_count == 0 && $failed_count > 0) {
        echo $failed_count . " PO(s) updated";
    }
} else {
    echo "No orders selected";
}
