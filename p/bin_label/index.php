<?php
require(__DIR__ . '/../../dbconnect/db.php');

require('mysql_table.php');
require('CevicheOne-Regular.php');
// require(__DIR__ . '../../../dbconnect/db.php');


class PDF extends PDF_MySQL_Table
{

  function Header()
  {
    require(__DIR__ . '/../../dbconnect/db.php');

    $TRFSearch =  htmlspecialchars($_GET['link'] ?? '');

    // $TRFSearch = 'SO573949';
    // $Response4 = 'somreer';
    // $CUST_ = 'gnag';


    $sql = "SELECT * FROM INB_PACK_LIST_DETAIL WHERE packListId=? GROUP BY packListId";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $TRFSearch);
    // $search = $findOrder;
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
      while ($row = $result->fetch_assoc()) {
        $packListId =$row['packListId'];
        $CustomerName = $row['CustomerName'];
        $SalesOrderNumber = $row['SalesOrderNumber'];
        $Courier = $row['Courier'];
        $ConsignmentNote = $row['ConsignmentNote'];
        $PalletCount = $row['PalletCount'];
        $BoxCount = $row['BoxCount'];
        
      }
    } else {
      echo "";
    }
    

    $this->setFillColor(255,255,255,255); 
    $this->SetTextColor(0,0,0,0);
    $this->SetY(2);
    $this->SetX(1);
    $this->AddFont('CCode39','','ConnectCode39.php');
    $this->SetFont('CCode39','',40);
    $this->Cell(13, 3, '*'.$TRFSearch.'*', 0, 1, 'C', 1);

    $this->SetY(5);
    $this->SetX(1);
    $this->SetFont('Arial', '', 45);
    $this->Cell(13, 3, $TRFSearch, 0, 1, 'C', 1);

    parent::Header();
  }
}

$pickDetails = htmlspecialchars($_GET['linked'] ?? '');


$pdf = new PDF('L','cm',array(10,15.25));
$pdf->AliasNbPages();
// $pdf->AddPage();

$pdf->Output();
