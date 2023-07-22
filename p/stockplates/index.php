<?php

session_start();
if (!isset($_SESSION['LOGGED'])) {
    header('Location: ../../');
}
?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<?php include('../common/header.html'); ?>

<style>
    img.barcode {
        border: 1px solid #ccc;
        padding: 20px 10px;
        border-radius: 5px;
    }
</style>

<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container-fluid" data-layout="container">
            <script>
                var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                if (isFluid) {
                    var container = document.querySelector('[data-layout]');
                    container.classList.remove('container');
                    container.classList.add('container-fluid');
                }
            </script>

            <?php include('../../menu/main_nav.php'); ?>
            <div class="content">
                <?php include('../../menu/sub_nav.php'); ?>

                <div class="card mb-3">
                    <!--/.bg-holder-->
                    <div class="card-header bg-light">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="card-header-title mb-0 col-12">Print Stockplates</h5>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-2 ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as read</a></div> -->
                        </div>
                    </div>
                    <div class="card-body position-relative">
                        <!-- Body -->
                        <div class="row">
                            <form method="post" name="plateform" id="plateform">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Plate count to print:</label>
                                            <select name="barcodeType" id="barcodeType" class="form-select mb-2">
                                                <option value="Select">Select</option>
                                                <option value="1">1</option>
                                                <option value="10">10</option>
                                                <option value="50">50</option>
                                                <option value="80">80</option>
                                                <option value="100">100</option>
                                                <option value="200">200</option>
                                            </select>
                                        </div>

                                        <input type="hidden" name="barcodeSize" id="barcodeSize" value="20">
                                        <input type="hidden" name="printText" id="printText" value="true">
                                        <input type="submit" id="generateBarcode" name="generateBarcode" class="btn btn-primary form-control generateBarcode mb-2" value="Build Plates">
                                        <a type="button" name="printbc" id="printbc" class="btn btn-falcon-default form-control pb-2" target="_blank" href="print.php?p=">Print</a>
                                        <div class="errors mt-2" style="color:var(--falcon-red); font-size: 13px; margin-top: 6px; font-family: var(--falcon-font-sans-serif)"></div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="col-md-4" id="content_plates"></div>
                                    </div>
                                </div>
                            </form>
                            <!-- close body -->
                        </div>
                    </div>
                    <footer class="footer" style="font-family: 'Poppins'; font-size: 13px">
                        <!-- footer -->
                    </footer>
                </div>
            </div>
        </div>

    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <?php include('../common/footer.html'); ?>
</body>

</html>

<script>
    $(document).ready(function(){
        $('#printbc').hide();
    });
    // $('#printbc').hide();
    $('#barcodeType').on('change', function(xc) {
        xc.preventDefault();
        var CurrentVal = $('#barcodeType').val();
        if (CurrentVal == 'Select') {
            $('#errors').html('Select number of plates to print');
        } else if (CurrentVal == '1') {
            var __href = 'print.php?p=';
            $("#printbc").attr("href", __href + 'a');
        } else if (CurrentVal == '10') {
            var __href = 'print.php?p=';
            $("#printbc").attr("href", __href + 'v');
        } else if (CurrentVal == '50') {
            var __href = 'print.php?p=';
            $("#printbc").attr("href", __href + 'b');
        } else if (CurrentVal == '80') {
            var __href = 'print.php?p=';
            $("#printbc").attr("href", __href + 'r');
        } else if (CurrentVal == '100') {
            var __href = 'print.php?p=';
            $("#printbc").attr("href", __href + 'j');
        } else if (CurrentVal == '200') {
            var __href = 'print.php?p=';
            $("#printbc").attr("href", __href + 'l');
        }

    });

    $('#plateform').on('submit', function(ee) {
        ee.preventDefault();
        var selection = $('#barcodeType option:selected').val();
        if(selection == 'Select') {
            $('.errors').html('Select number of stockplates to print');
        } else {
            $('#printbc').show();
            $('.errors').html('');
        
        $('#messenger_a').show();
        var clickId = $(this).attr('id');
        var barcodeSize = $('#barcodeSize').val();
        var printText = $('#printText').val();
        var platecount = $('#barcodeType').val();

        $.ajax({
            url: "populate_plates.php", //the page containing php script
            type: "POST", //request type,
            data: {
                link: clickId,
                barcodeSize: barcodeSize,
                printText: printText,
                platecount: platecount
            },
            success: function(result) {
                // alert(result);
                $('#content_plates').html(result);
                $('#messenger_a').hide();
                $('#printbc').show();
            },
            error: function(err) {
                //alert('Error : WZSD323');
                console.log(err);
                alert(err);
            }
        });
    }
    });
</script>