<?php
ini_set('session.cookie_domain', '.inbracket.com' );
session_start();

$ProductCode = $_POST['ProductCode'];
$PickfaceStock = 0;
$WarehouseId = '1';
$Pickface = $_POST['Pickface'];

include(__DIR__.'/../../dbconnect/db.php');

    $stmt1 = $conn->prepare("SELECT ProductCode FROM INB_PICKFACE_STOCK WHERE ProductCode=?");
    $stmt1->bind_param('s', $ProductCode);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    if ($result1->num_rows === 0) {
        //add
        $stmt = $conn->prepare("INSERT INTO INB_PICKFACE_STOCK (ProductCode, PickfaceStock, WarehouseId, Pickface) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('siss', $ProductCode, $PickfaceStock, $WarehouseId, $Pickface);
        $stmt->execute();

        $result2 = $stmt->get_result();
        if ($result2->num_rows === 0) {
            echo "Error - Couldn't create a pickface. Try again.";
        } else {
            echo "Pickface assigned";
        }
        $stmt->close();
    } else {
        echo "A pickface already exists for the selected product";
    }