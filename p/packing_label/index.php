<?php
require(__DIR__ . '/../../dbconnect/db.php');

require(__DIR__ . '/mysql_table.php');
require(__DIR__ . '/CevicheOne-Regular.php');
// require(__DIR__ . '../../../dbconnect/db.php');


class PDF extends PDF_MySQL_Table
{

  // function Header()
  // {
  //   require(__DIR__ . '/../../dbconnect/db.php');

  //   $TRFSearch =  htmlspecialchars($_GET['linked'] ?? '');

  //   // $TRFSearch = 'SO573949';
  //   // $Response4 = 'somreer';
  //   // $CUST_ = 'gnag';


  //   $sql = "SELECT * FROM INB_PACK_LIST_DETAIL WHERE packListId=? GROUP BY packListId";

  //   $stmt = $conn->prepare($sql);
  //   $stmt->bind_param("s", $TRFSearch);
  //   // $search = $findOrder;
  //   $stmt->execute();
  //   $result = $stmt->get_result();

  //   $i = 0;
  //   if (mysqli_num_rows($result) > 0) {
      
  //     while ($row = $result->fetch_assoc()) {
  //       // if ($i % 3 == 0) {
  //       //   //
  //       // } else {
  //         $packListId = $row['packListId'];
  //         $CustomerName = $row['CustomerName'];
  //         $SalesOrderNumber = $row['SalesOrderNumber'];
  //         $Courier = $row['Courier'];
  //         $ConsignmentNote = $row['ConsignmentNote'];
  //         $PalletCount = (int)$row['PalletCount'];
  //         $BoxCount = (int)$row['BoxCount'];
  //         $total_print = $BoxCount + $PalletCount;
  //       // }
  //     }
  //   } else {
  //     echo "";
  //   }

    

  //   // Title
  //   $pdf->Cell(2, 0, "", 0, 1, 'R', $pdf->Image('https://www.grwills.com.au/wp-content/uploads/2022/12/GR_Wills_Logo_RGB-1400x452.jpg', 7, 0.1, 2.2, 0.8));
  //   // $pdf->Line(280, 32, 16, 32);
  //   //$pdf->Image('../../assets/img/logo.gif',10,10,-300);
  //   $pdf->SetY(0.1);
  //   $pdf->SetX(1);
  //   $pdf->SetFont('Arial', 'B', 10);
  //   $pdf->Cell(1, 1, 'FROM:', 0, 1);

  //   $pdf->SetY(1);
  //   $pdf->SetX(1);
  //   $pdf->SetFont('Arial', '', 10);
  //   $pdf->Cell(5, 0.3, 'G&R Wills Wholesalers', 0, 1);
  //   // $pdf->Ln(1);
  //   $pdf->SetY(1.4);
  //   $pdf->SetX(1);
  //   $pdf->MultiCell(5, 0.3, '34, Osgood Drive, Eaton, Northern Territory, Australia, 0810', 0, 1);

  //   $pdf->SetY(2.6);
  //   $pdf->SetX(1);
  //   $pdf->SetFont('Arial', 'B', 10);
  //   $pdf->MultiCell(5, 0.3, 'SHIP TO:', 0, 1);

  //   $pdf->SetY(3.2);
  //   $pdf->SetX(1);
  //   $pdf->SetFont('Arial', '', 10);
  //   $pdf->MultiCell(6, 0.3, $CustomerName, 0, 1);

  //   $pdf->SetY(3.6);
  //   $pdf->SetX(1);
  //   $pdf->SetFont('Arial', '', 10);
  //   $pdf->MultiCell(6, 0.3, '34, Osgood Drive, Eaton, Northern Territory, Australia, 0810', 0, 1);

  //   $pdf->SetY(4.5);
  //   $pdf->SetX(1);
  //   $pdf->SetFont('Arial', 'B', 10);
  //   $pdf->Cell(6, 0.3, 'PACK LIST:', 0, 1);

  //   $pdf->SetY(5);
  //   $pdf->SetX(1);
  //   $pdf->SetFont('Arial', 'B', 23);
  //   $pdf->setFillColor(0, 0, 0, 0);
  //   $pdf->SetTextColor(255, 255, 255, 255);
  //   $pdf->Cell(8, 1.5, $packListId."-".$total_print."/".$value, 0, 1, 'C', 1);
    
   

  //   $pdf->setFillColor(255, 255, 255, 255);
  //   $pdf->SetTextColor(0, 0, 0, 0);
  //   $pdf->SetY(7.2);
  //   $pdf->SetX(1);
  //   $pdf->AddFont('CCode39', '', 'ConnectCode39.php');
  //   $pdf->SetFont('CCode39', '', 22);
  //   $pdf->Cell(8, 2.3, '*' . $SalesOrderNumber . '*', 0, 1, 'C', 1);

  //   $pdf->SetY(8.5);
  //   $pdf->SetX(1);
  //   $pdf->SetFont('Arial', 'B', 10);
  //   $pdf->Cell(3, 3, 'SHIPPING DETAIL:', 0, 1);

  //   $pdf->SetY(9);
  //   $pdf->SetX(1);
  //   $pdf->SetFont('Arial', 'B', 10);
  //   $pdf->Cell(3, 3, 'Transport Co:', 0, 1);

  //   $pdf->SetY(9.4);
  //   $pdf->SetX(1);
  //   $pdf->SetFont('Arial', '', 10);
  //   $pdf->Cell(3, 3, $Courier, 0, 1);

  //   $pdf->SetY(9);
  //   $pdf->SetX(4);
  //   $pdf->SetFont('Arial', 'B', 10);
  //   $pdf->Cell(6, 3, 'Consignment Note:', 0, 1);

  //   $pdf->SetY(9.4);
  //   $pdf->SetX(4);
  //   $pdf->SetFont('Arial', '', 10);
  //   $pdf->Cell(3, 3, $ConsignmentNote, 0, 1);

  //   $pdf->SetY(10.5);
  //   $pdf->SetX(1);
  //   $pdf->SetFont('Arial', 'B', 10);
  //   $pdf->Cell(3, 3, 'ORDER DETAIL:', 0, 1);

  //   $pdf->SetY(11);
  //   $pdf->SetX(1);
  //   $pdf->SetFont('Arial', 'B', 10);
  //   $pdf->Cell(6, 3, 'Pallet Count:', 0, 1);

  //   $pdf->SetY(11.4);
  //   $pdf->SetX(1);
  //   $pdf->SetFont('Arial', '', 10);
  //   $pdf->Cell(3, 3, $PalletCount, 0, 1);

  //   $pdf->SetY(11);
  //   $pdf->SetX(4);
  //   $pdf->SetFont('Arial', 'B', 10);
  //   $pdf->Cell(6, 3, 'Box Count:', 0, 1);

  //   $pdf->SetY(11.4);
  //   $pdf->SetX(4);
  //   $pdf->SetFont('Arial', '', 10);
  //   $pdf->Cell(3, 3, $BoxCount, 0, 1);

  //   $pdf->SetY(12);
  //   $pdf->SetX(1);
  //   $pdf->SetFont('Arial', 'B', 10);
  //   $pdf->Cell(3, 3, 'Order Ref:', 0, 1);

  //   $pdf->SetY(12.4);
  //   $pdf->SetX(1);
  //   $pdf->SetFont('Arial', '', 10);
  //   $pdf->Cell(3, 3, $SalesOrderNumber, 0, 1);
  //   parent::Header();
  // }
}

$pickDetails = htmlspecialchars($_GET['linked'] ?? '');
$PrintCounter = htmlspecialchars($_GET['pcount'] ?? '');

$pdf = new PDF('P', 'cm', array(10, 15));
// $pdf->SetMargins(1, 1);


$number = range(1,$PrintCounter);
$myarray = $number;
foreach($myarray as $value){
  $pdf->SetAutoPageBreak(false);
  $pdf->AddPage();

  require(__DIR__ . '/../../dbconnect/db.php');

    $TRFSearch =  htmlspecialchars($_GET['linked'] ?? '');
    // $TRFSearch = 'SO573949';
    // $Response4 = 'somreer';
    // $CUST_ = 'gnag';


    $sql = "SELECT * FROM INB_PACK_LIST_DETAIL de
    LEFT OUTER JOIN INB_CUSTOMER_LIST li on li.CustomerId=de.OrderCustomerId
    WHERE de.packListId=? GROUP BY de.packListId";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $TRFSearch);
    // $search = $findOrder;
    $stmt->execute();
    $result = $stmt->get_result();

    $i = 0;
    if (mysqli_num_rows($result) > 0) {
      
      while ($row = $result->fetch_assoc()) {
        // if ($i % 3 == 0) {
        //   //
        // } else {
          $packListId = $row['packListId'];
          $CustomerName = $row['CustomerName'];
          $SalesOrderNumber = $row['SalesOrderNumber'];
          $Courier = $row['Courier'];
          $ConsignmentNote = $row['ConsignmentNote'];
          $PalletCount = (int)$row['PalletCount'];
          $BoxCount = (int)$row['BoxCount'];
          $total_print = $BoxCount + $PalletCount;
          $address = $row['AddressStreet'] . ', ' . $row['AddressSuburb'] . ', '. $row['AddressState'] . ','. $row['AddressPostCode'];
        // }
      }
    } else {
      echo "";
    }

    //test

    

    // Title
    $pdf->Cell(2, 1, "", 0, 1, 'R', $pdf->Image('https://www.grwills.com.au/wp-content/uploads/2022/12/GR_Wills_Logo_RGB-1400x452.jpg', 6.5, 1.5, 2.4, 0.8));
    // $pdf->Line(280, 32, 16, 32);
    //$pdf->Image('../../assets/img/logo.gif',10,10,-300);
    $pdf->SetY(1.6);
    $pdf->SetX(0.7);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(1, 0.5, 'FROM:', 0, 1);

    $pdf->SetY(2.2);
    $pdf->SetX(0.7);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(5, 0.3, 'G&R Wills Wholesalers', 0, 1);
    // $pdf->Ln(1);
    $pdf->SetY(2.6);
    $pdf->SetX(0.7);
    $pdf->MultiCell(7, 0.4, '34, Osgood Drive, Eaton, Northern Territory, Australia, 0810', 0, 1);

    $pdf->SetY(3.7);
    $pdf->SetX(0.7);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->MultiCell(5, 0.3, 'SHIP TO:', 0, 1);

    $pdf->SetY(4.1);
    $pdf->SetX(0.7);
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(7, 0.3, $CustomerName, 0, 1);

    $pdf->SetY(4.5);
    $pdf->SetX(0.7);
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(7, 0.4, $address, 0, 1);

    $pdf->SetY(5.6);
    $pdf->SetX(0.7);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(3, 0.3, 'PACK LIST:', 0, 1);

    $pdf->SetY(5.7);
    $pdf->SetX(0.7);
    $pdf->SetFont('Arial', 'B', 18);
    // $pdf->setFillColor(0, 0, 0, 0);
    // $pdf->SetTextColor(255, 255, 255, 255);
    $cellWidth = $pdf->GetStringWidth($packListId. '');
    $pdf->Cell($cellWidth + 0.5, 1.3, $packListId.'-'.$value. '', 0, 1);
    
    $pdf->SetY(5.5);
    $pdf->SetX(6);
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->SetTextColor(255, 255, 255, 255);
    $pdf->setFillColor(0, 0, 0, 0);
    $pdf->Cell(3.1, 1.3, $value." of ".$total_print, 0, 1, 'C', true);

    $pdf->setFillColor(255, 255, 255, 255);
    $pdf->SetTextColor(0, 0, 0, 0);
    $pdf->SetY(7.3);
    $pdf->SetX(1);
    $pdf->AddFont('CCode39', '', 'ConnectCode39.php');
    $pdf->SetFont('CCode39', '', 22);
    $pdf->Cell(8, 2.3, '*' . $SalesOrderNumber . '*', 0, 1, 'C', 1);

    $pdf->SetY(9.1);
    $pdf->SetX(0.7);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(3.3, 0.5, 'SHIPPING DETAIL:', 0, 1);

    $pdf->SetY(9.7);
    $pdf->SetX(0.7);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(3, 0.5, 'Transport Co:', 0, 1);

    $pdf->SetY(10.2);
    $pdf->SetX(0.7);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(3, 0.5, $Courier, 0, 1);

    $pdf->SetY(9.7);
    $pdf->SetX(5);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(4, 0.5, 'Consignment Note:', 0, 1);

    $pdf->SetY(10.2);
    $pdf->SetX(5);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(4, 0.5, $ConsignmentNote, 0, 1);

    $pdf->SetY(11);
    $pdf->SetX(0.7);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(3, 0.5, 'ORDER DETAIL:', 0, 1);

    $pdf->SetY(11.5);
    $pdf->SetX(0.7);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(3, 0.5, 'Pallet Count:', 0, 1);

    $pdf->SetY(12);
    $pdf->SetX(0.7);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(3, 0.5, $PalletCount, 0, 1);

    $pdf->SetY(11.5);
    $pdf->SetX(4);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(3, 0.5, 'Box Count:', 0, 1);

    $pdf->SetY(12);
    $pdf->SetX(4);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(3, 0.5, $BoxCount, 0, 1);

    $pdf->SetY(12.9);
    $pdf->SetX(0.7);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(3, 0.5, 'Order Ref:', 0, 1);

    $pdf->SetY(13.5);
    $pdf->SetX(0.7);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(3, 0.4, $SalesOrderNumber, 0, 1);
    // parent::Header();
  }
// }

$pdf->AliasNbPages();
// $pdf->AddPage();

$pdf->Output();
