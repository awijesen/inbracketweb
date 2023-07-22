<style>
	img.barcode {
		border: 1px solid #ccc;
		padding: 20px 10px;
		border-radius: 5px;
	}
</style>
<?php

session_start();

require(__DIR__ . '../../../dbconnect/db.php');

$sql = "SELECT LastPlate FROM INB_STOCKPLATE_TRACKER";

$stmt = $conn->prepare($sql);
// $stmt->bind_param("s", $search);
// $search = $findOrder;
$stmt->execute();
$result = $stmt->get_result();

if (mysqli_num_rows($result) > 0) {
	while ($row = $result->fetch_assoc()) {
		$lastplate = $row["LastPlate"];
	}
} else {
	$Response = "Data mining error!";
		echo $Response;
}

$barcodeText = $lastplate;
$start = 1;
$end = $_POST['platecount'];
$_SESSION['PCOUNT'] = $_POST['platecount'];
// $barcodeType = $_POST['barcodeType'];
$barcodeType = 'code128';
// $barcodeDisplay = $_POST['barcodeDisplay'];
$barcodeDisplay = 'horizontal';
$barcodeSize = $_POST['barcodeSize'];
$_SESSION['barcodeSize'] = $barcodeSize;
$printText = $_POST['printText'];
$_SESSION['printText'] = $printText;
if ($barcodeText != '') {
	while ($start <= $end) {
		echo '<img style="background-color: white" class="barcode" alt="' . $barcodeText . '" src="barcode.php?text=' . $barcodeText . '&codetype=' . $barcodeType . '&orientation=' . $barcodeDisplay . '&size=' . $barcodeSize . '&print=' . $printText . '"/>';
		$barcodeText++;
		$start++;
	}
	//echo "last number: " . $end . ($barcodeText - 1) . "";
} else {
	echo '<div class="alert alert-danger">Enter product name or number to generate barcode!</div>';
}

// if (isset($_POST['generateBarcode'])) {
// 	$barcodeText = trim($_POST['barcodeText']);
// 	// $barcodeType = $_POST['barcodeType'];
// 	$barcodeType = 'code128';
// 	// $barcodeDisplay = $_POST['barcodeDisplay'];
// 	$barcodeDisplay = 'horizontal';
// 	$barcodeSize = $_POST['barcodeSize'];
// 	$printText = $_POST['printText'];
// 	if ($barcodeText != '') {
// 		// echo '<h4>Barcode:</h4>';
// 		echo '<img class="barcode" alt="' . $barcodeText . '" src="barcode.php?text=' . $barcodeText . '&codetype=' . $barcodeType . '&orientation=' . $barcodeDisplay . '&size=' . $barcodeSize . '&print=' . $printText . '"/>';
// 	} else {
// 		echo '<div class="alert alert-danger">Enter product name or number to generate barcode!</div>';
// 	}
// }
?>