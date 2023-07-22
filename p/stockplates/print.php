<?php
session_start();

$link = $_POST['link'];
$barcodeSize = $_POST['barcodeSize'];
$printText = $_POST['printText'];

if($_GET['p'] == 'a') {
    $platecounter = 1;
} else if($_GET['p'] == 'v') {
    $platecounter = 10;
} else if($_GET['p'] == 'b') {
    $platecounter = 50;
} else if($_GET['p'] == 'r') {
    $platecounter = 80;
} else if($_GET['p'] == 'j') {
    $platecounter = 100;
} else if($_GET['p'] == 'l') {
    $platecounter = 200;
}

?>
<style>
    body {
        margin: 0 !important;
        padding: 0 !important;
    }

    .barcode {
        height: 50px;
        width: 160px;
        padding: 5px 2px;
        border-radius: 5px;

        margin-bottom: 5px;
        margin-top: 5px;
        align-content: center;

    }

    .barcoder {
        height: 50px;
        width: 160px;
        border-radius: 5px;

        margin-bottom: 5px;
        margin-top: 5px;
        align-content: center;

    }
</style>

<div class="col-md-4">
    <?php
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
    $end = $platecounter;
    // $barcodeType = $_POST['barcodeType'];
    $barcodeType = 'code128';
    // $barcodeDisplay = $_POST['barcodeDisplay'];
    $barcodeDisplay = 'horizontal';
    $barcodeSize = 20;
    $printText = 'true';


    if ($barcodeText != '') {
        while ($start <= $end) {
            echo '<div class="barcoder">
                    <img style="width: 100%; margin-top: 15px" alt="' . $barcodeText . '" src="https://workspace.inbracket.com/p/stockplates/barcode.php?text=' . $barcodeText . '&codetype=' . $barcodeType . '&orientation=' . $barcodeDisplay . '&size=' . $barcodeSize . '&print=' . $printText . '"/><br>
                    <div style="text-align: center; width: 100%; margin-top: -5px;">RECEIVED</div>
                    </div>';
            $barcodeText++;
            $start++;
        }

        require(__DIR__ . '../../../dbconnect/db.php');

        $sql = "UPDATE INB_STOCKPLATE_TRACKER set LastPlate=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            'i',
            $barcodeText
        );

        $status = $stmt->execute();
        if ($status) {
            //success
        } else {
            //falied
            die;
        }
    ?><script>
            window.print();
        </script><?php
                } else {
                    echo '<div class="alert alert-danger">Enter product name or number to generate barcode!</div>';
                }
                // }
                    ?>
</div>
<!-- </div> -->
<!-- </div> -->
<?php //include('footer.php'); 
?>