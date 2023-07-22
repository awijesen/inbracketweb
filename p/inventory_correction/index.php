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
                                    <div class="col-12">
                                        <h5 class="card-header-title mb-0 col-12">Stock Adjustment</h5>
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

                            <div class="col-auto"><button class="btn btn-primary" type="submit" id="search-product-btn">&nbsp;Submit&nbsp;</button></div>
                        </form>
                        <div class="col-6" id="fetched-data" style="color:var(--falcon-red); font-size: 13px; margin-top: 6px; font-family: var(--falcon-font-sans-serif);"></div>
                        <div class="col-6" id="prodetail" style="font-size: 15px; margin-top: 6px; font-family: var(--falcon-font-sans-serif);"></div>
                        <div class="row align-items-center" id="secondary_">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 pb-2">
                                    <input type="text" name="stk_change" id="stk_change" class="form-control" placeholder="Quantity change" />
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 pb-2">
                                    <select class="form-select" name="change_reason" id="change_reason">
                                        <option value="select_reason">Select</option>
                                        <option value="CY">Cycle Count Adjustment</option>
                                        <option value="DM">Damaged</option>
                                        <option value="EX">Expired Stock</option>
                                        <option value="DN">Donation</option>
                                        <option value="WR">Write Off</option>
                                        <option value="VC">Vendor Claim</option>
                                        <option value="ST">Staff Use</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 pb-2">
                                    <textarea type="text" name="change_notes" id="change_notes" class="form-control" placeholder="Notes" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-5 d-flex flex-row">
                                <input type="button" name="save_changes" id="save_changes" class="btn btn-primary" value="Commit" />
                                <input type="button" name="clear_changes" id="clear_changes" class="btn btn-secondary ms-2" value="Clear" />
                            </div>
                        </div>
                        <div class="row" id="secondary_">
                            <div id="alertmsg" class="col-5" style="padding-top: 10px !important; color: red; font-size: 12px; font-family: var(--falcon-font-sans-serif)"></div>
                        </div>
                    </div>


                    <!-- close body -->
                </div>
            </div>
            <footer class="footer" style="font-family: 'Poppins'; font-size: 13px">
                <!-- footer -->
            </footer>
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
    $(document).ready(function() {
        $('#secondary_').hide();

        $('#search-product').on('submit', function(aa) {
            aa.preventDefault();
            // $('#loaderImgx').show();
            var formData = $('#search-product').serialize();

            $.ajax({
                type: "POST",
                data: formData,
                url: "_fetch.php",
                success: function(msg) {
                    if (msg === 'Invalid product code') {
                        $('#fetched-data').html(msg);
                        $('#prodetail').html('');
                        $('#secondary_').hide();
                        $('#stk_change').val('');
                        $('#change_notes').val('');
                        $('#change_reason').prop('selectedIndex', 0);
                    } else if (msg === 'Product code required') {
                        $('#fetched-data').html(msg);
                        $('#prodetail').html('');
                        $('#change_notes').val('');
                        $('#change_reason').prop('selectedIndex', 0);
                    } else {
                        $('#prodetail').html(msg);
                        $('#fetched-data').html('');
                        $('#change_notes').val('');
                        $('#secondary_').show();
                        $('#change_reason').prop('selectedIndex', 0);
                        $('#alertmsg').html('');
                        $("#autoSizingInputProduct").prop('disabled', true);
                        $(':input[type="submit"]').prop('disabled', true);
                    }
                    // $('#loaderImgx').hide();
                }
            });
        });
    });

    $('#save_changes').on('click', function(ed) {
        ed.preventDefault();
        var pcode = $('#autoSizingInputProduct').val();
        var cqty = $('#stk_change').val();
        var reason_ = $('#change_reason option:selected').val();
        var price_ = $('#currentprice').val();
        var notes_ = $('#change_notes').val();

        if (pcode == '') {
            $('#alertmsg').html('Product code required');
        } else if (cqty == '') {
            $('#alertmsg').html('Quantity change is required');
        } else if (reason_ === 'select_reason') {
            $('#alertmsg').html('Select inventory correction reason');
        } else if (notes_ === '' || notes_.length < 2) {
            $('#alertmsg').html('Change note is required');
        } else {
            $.ajax({
                type: "POST",
                data: {
                    change: cqty,
                    code: pcode,
                    reasoncode: reason_,
                    pricep: price_,
                    notes: notes_ 
                },
                url: "_commit.php",
                success: function(data) {
                    $('#autoSizingInputProduct').removeAttr('disabled');
                    $(':input[type="submit"]').prop('disabled', false);
                    $('#alertmsg').html(data);
                    $('#stk_change').val('');
                    $('#secondary_').hide();
                }
            });
        }
    })

    $('#clear_changes').on('click', function(ry) {
        ry.preventDefault();
        $('#autoSizingInputProduct').removeAttr('disabled');
        $(':input[type="submit"]').prop('disabled', false);
    })
</script>