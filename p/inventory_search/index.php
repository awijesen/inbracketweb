<?php

session_start();
if (!isset($_SESSION['LOGGED'])) {
    header('Location: ../../');
}
?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<?php include('../common/header.html'); ?>


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

                <div class="card mb-3 search_content_stkenq">
                    <!--/.bg-holder-->
                    <div class="card-header bg-light">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-3">
                                        <h5 class="card-header-title mb-0 col-12">Stock Enquiry</h5>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-2 ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as read</a></div> -->
                        </div>
                    </div>
                    <div class="card-body position-relative">
                        <!-- Body -->

                        <form class="row gy-2 gx-3 align-items-center" id="search-product">
                            <div class="col-auto">
                                <!-- <label class="visually-hidden" for="autoSizingInputProduct">Name</label> -->
                                <input class="form-control" name="autoSizingInputProduct" id="autoSizingInputProduct" type="text" placeholder="Product code" />
                            </div>

                            <div class="col-auto"><button class="btn btn-primary" type="submit" id="search-product-btn">Submit</button></div>
                        </form>
                        <!-- <div class="col-6" id="fetched-data" style="color:var(--falcon-red); font-size: 13px; margin-top: 6px;"></div> -->
                        <div class="col-6" id="fetched-data" style="color:var(--falcon-gray); font-size: 18px; font-family: 'Poppins'; margin-top: 6px;"></div>

                        <!-- close body -->
                    </div>
                </div>
                <footer class="footer" style="font-family: 'Poppins'; font-size: 13px">
                    <!-- footer -->
                </footer>
            </div>
            

            <div class="modal fade" id="modalDetailer" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="ConfirmationModalDelLabel" aria-hidden="true">
                <!-- <div class="modal fade" id="modalDetailer" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalDetailerLabel" aria-hidden="true"> -->
                <div class="modal-dialog modal-sm mt-6" role="document">
                    <div class="modal-content border-0">
                        <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button></div>
                        <div class="modal-body p-0">
                            <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                                <h4 class="mb-1" id="modalDetailerLabel">Replenish Stock</h4>
                                <div class="" style="font-family: 'Poppins'; font-size: 12px">Replenish from <span id="aac"></span><br></div>
                            </div>
                            <div class="p-4">
                                <div class="row">
                                    <div class="col-lg-9"></div>

                                    <label for="replen-qty">Replenish Quantity :</label>
                                    <div class="replen-qty">
                                        <input id="actionQty" type="number" class="form-control form-control-sm">
                                    </div>
                                    <input id="aa" type="hidden">
                                    <input id="bb" type="hidden">
                                    <input id="bbb" type="hidden">
                                    <input id="bbbb" type="hidden">
                                    <input id="pf_" type="hidden">
                                    <input id="ds_" type="hidden">
                                    <div id="err-msg" class="col-lg-12 col-md-12" style="color:var(--falcon-red); font-size: 12px; margin-top: 10px; margin-bottom: 10px;">&nbsp;</div>
                                    <div class="col-lg-12 col-md-12 d-flex justify-content-center">
                                        <input type="button" class="btn btn-falcon-primary btn-sm" id="process-replen" value="Process">
                                        <img id="spinner-indicator" src="../../assets/img/spinner.gif" height="40px" />
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
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
    $(document).on('click', 'tr td #replentrigger', function(xc) {
        xc.preventDefault();
        var bulkLoc = $(this).attr('stk_loc');
        var pfLoc = $(this).attr('stk_pf');
        var IDN = $(this).attr('stk_bk_id');
        var stock_holding = $(this).attr('stock_holding');
        $('#aac').html(bulkLoc);
        $('#aa').val(bulkLoc);
        $('#bb').val(pfLoc);
        $('#bbb').val(IDN);
        $('#bbbb').val(stock_holding);
        $('#modalDetailer').modal('show');

    });


    $(document).ready(function() {
        $('#spinner-indicator').hide();
        $('#search-product').on('submit', function(aa) {
            aa.preventDefault();
            // $('#loaderImgx').show();
            var formData = $('#search-product').serialize();

            $.ajax({
                type: "POST",
                data: formData,
                url: "_fetch.php",
                success: function(msg) {
                    if(msg === 'Invalid product code' || msg === 'Product code required' ) {
                        $('#fetched-data').html('<span style="color:var(--falcon-red); font-size: 13px; margin-top: 6px;">'+msg+'</span>');    
                    } else {
                    $('#fetched-data').html(msg);
                    }
                    // $('#loaderImgx').hide();
                }
            });
        });

    });

    $('#process-replen').on('click', function(gg) {
        gg.preventDefault(gg);
        $('#process-replen').prop('value', 'Processing ...');
        var availableBlk = parseInt($('#bbbb').val());
        var keyedInval = parseInt($('#actionQty').val());
    

        if (availableBlk < keyedInval) {
            $('#err-msg').html('Replenishing quantity can not exceed selected bulk location quantity.');
            setInterval(function() {
                $('#process-replen').prop('value', 'Process');
            }, 2000)

        } else {
            // $('#err-msg').html('');
            $('#process-replen').prop('value', 'Process');
            var curBlk = $('#bbb').val();
            var bulkLoc = $('#aa').val();
            var prodCode = $('#bb').val();
            var curBlkStock = $('#bbbb').val();
            var des_ = $('#ds_').val();
            var pff = $('#pf_').val();
            $.ajax({
                type: "POST",
                data: {
                    descrp: des_,
                    pface: pff,
                    fromLoc: bulkLoc,
                    currentBulk: curBlk,
                    replenQty: keyedInval,
                    productCode: prodCode,
                    currentBulkStock: curBlkStock
                },
                url: "replenish.php",
                success: function(msg) {
                    $('#spinner-indicator').show();
                    $('#process-replen').hide();
                    $('#err-msg').html(msg);
                    if(msg === 'Success'){
                        $('#err-msg').html('<span style="color: green">Success!</span>');
                    } else {
                        $('#err-msg').html(msg);
                    }
                    setTimeout(function() {
                        $('#modalDetailer').modal('hide');
                    }, 1000);
                }
            });

        }
        
    });

    $('#modalDetailer').on('hidden.bs.modal', function(e) {
            $('#actionQty').val('');
            $('#err-msg').html('');
            $('#aa').val('');
            $('#bb').val('');
            $('#bbb').val('');
            $('#bbbb').val('');
            $('#pf_').val('');
            $('#ds_').val('');
            $('#spinner-indicator').hide();
            $('#process-replen').show();
            $('#search-product').trigger('submit');
        });

    $('#modalDetailer').on('shown.bs.modal', function(es) {
            var prod = $('#bb').val();

            $.ajax({
                type: "POST",
                data: {
                    prodCode: prod
                },
                url: "_additional_data.php",
                success: function(res) {
                   if(jQuery.parseJSON(res).Alert_ === 'Error') {
                    alert('Error_78AQ');
                } else {
                $('#pf_').val(jQuery.parseJSON(res).pickface_);
                $('#ds_').val(jQuery.parseJSON(res).description_);
                }
            }
            });

        });
</script>