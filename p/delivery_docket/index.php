<?php
require(__DIR__ . '/../../dbconnect/db.php');

require('mysql_table.php');
// require(__DIR__ . '../../../dbconnect/db.php');


class PDF extends PDF_MySQL_Table
{

  function Header()
  {
    require(__DIR__ . '/../../dbconnect/db.php');

    $TRFSearch =  htmlspecialchars($_GET['linked'] ?? '');

    // $TRFSearch = 'SO573949';
    // $Response4 = 'somreer';
    // $CUST_ = 'gnag';


    $sql = "SELECT OrderCustomer, ShipDay, Reference FROM GRW_INB_SALES_ORDERS WHERE SalesOrderNumber=? GROUP BY SalesOrderNumber";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $TRFSearch);
    // $search = $findOrder;
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
      while ($row = $result->fetch_assoc()) {
        $CUST_ =$row['OrderCustomer'];
        $Response3 = $row['ShipDay'];
        if ($Response3 == 'Special') {
          $Response4 = 'Special';
        } else if ($Response3 == 'NATS') {
          $Response4 = 'NATS';
        } else if ($Response3 == '' || $Response3 == null) {
          $Response4 = '';
        } else {
          $Response4 = substr($Response3, 2, 40);
        }
      }
    } else {
      echo "";
    }

    // Title
    $this->Cell(90, 0, "", 0, 1, 'C', $this->Image('https://www.grwills.com.au/wp-content/uploads/2022/12/GR_Wills_Logo_RGB-1400x452.jpg', 10, 5, 50, 16));
    $this->Line(280, 32, 16, 32);
    //$this->Image('../../assets/img/logo.gif',10,10,-300);
    $this->SetFont('Arial', '', 18);
    $this->Cell(0, 6, 'Delivery Docket', 0, 1, 'C');
    $this->SetFont('Arial', '', 14);
    $this->Cell(0, 9, $Response4, 0, 1, 'C');
    $this->Cell(270, -8, $this->Code39(228, 8, $TRFSearch, 1, 7), 0, 1, 'R');
    $this->SetFont('Arial', '', 10);
    $this->Cell(271, 2, $TRFSearch, 0, 1, 'R');
    $this->SetFont('Arial', '', 10);
    $this->Cell(271, 6, $CUST_, 0, 1, 'R');
    $this->SetFont('Arial', '', 10);
    $this->Cell(271, 3, 'Status: Delivery Ready', 0, 1, 'R');
    $this->Ln(3);
    // Ensure table header is printed
    parent::Header();
  }
}

$pickDetails = htmlspecialchars($_GET['linked'] ?? '');
// $pickDetails = 'SO573949';
// Connect to database
//$link = mysqli_connect('localhost','','','test');

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
// Second table: specify 3 columns
$pdf->AddCol('CODE', 25, 'CODE', 'L');
$pdf->AddCol('PRODUCT DESCRIPTION', 100, 'DESCRIPTION');
$pdf->AddCol('BARCODE', 40, 'BARCODE', 'C');
$pdf->AddCol('ORDER QTY', 30, 'ORDER QTY', 'C');
$pdf->AddCol('PICKED QTY', 30, 'PICKED QTY', 'C');
$pdf->AddCol('REASON CODE', 40, 'REASON CODE', 'C');
$prop = array(
  'HeaderColor' => array(169, 169, 169),
  'color1' => array(255, 255, 255),
  'color2' => array(223, 223, 223),
  'padding' => 2
);
$pdf->Table($link, "SELECT 
cmp.ProductCode as 'CODE',
pm.ProductDescription as 'PRODUCT DESCRIPTION',
pm.Barcode as 'BARCODE',
cmp.OrderQuantity as 'ORDER QTY',
cmp.PickedQty as 'PICKED QTY',
cmp.ReasonCode as 'REASON CODE'
FROM INB_COMPLETED_PICKS cmp
LEFT OUTER JOIN INB_PRODUCT_MASTER pm on pm.ProductCode=cmp.ProductCode
where cmp.SalesOrderNumber='" . $pickDetails . "'
GROUP BY cmp.ProductCode
ORDER BY pm.ProductCode ASC", $prop);
$pdf->Output();
