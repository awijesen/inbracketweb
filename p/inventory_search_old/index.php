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
                        <div class="col-6" id="fetched-data" style="color:var(--falcon-red); font-size: 13px; margin-top: 6px;"></div>

                        <!-- close body -->
                    </div>
                </div>
                <footer class="footer" style="font-family: 'Poppins'; font-size: 13px">
                    <!-- footer -->
                </footer>
            </div>
            <div class="modal fade" id="authentication-modal" tabindex="-1" role="dialog" aria-labelledby="authentication-modal-label" aria-hidden="true">
                <div class="modal-dialog mt-6" role="document">
                    <div class="modal-content border-0">
                        <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                            <div class="position-relative z-index-1 light">
                                <h4 class="mb-0 text-white" id="authentication-modal-label">Register</h4>
                                <p class="fs--1 mb-0 text-white">Please create your free Falcon account</p>
                            </div>
                            <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-4 px-5">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label" for="modal-auth-name">Name</label>
                                    <input class="form-control" type="text" autocomplete="on" id="modal-auth-name" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="modal-auth-email">Email address</label>
                                    <input class="form-control" type="email" autocomplete="on" id="modal-auth-email" />
                                </div>
                                <div class="row gx-2">
                                    <div class="mb-3 col-sm-6">
                                        <label class="form-label" for="modal-auth-password">Password</label>
                                        <input class="form-control" type="password" autocomplete="on" id="modal-auth-password" />
                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <label class="form-label" for="modal-auth-confirm-password">Confirm Password</label>
                                        <input class="form-control" type="password" autocomplete="on" id="modal-auth-confirm-password" />
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="modal-auth-register-checkbox" />
                                    <label class="form-label" for="modal-auth-register-checkbox">I accept the <a href="#!">terms </a>and <a href="#!">privacy policy</a></label>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Register</button>
                                </div>
                            </form>
                            <div class="position-relative mt-5">
                                <hr class="bg-300" />
                                <div class="divider-content-center">or register with</div>
                            </div>
                            <div class="row g-2 mt-2">
                                <div class="col-sm-6"><a class="btn btn-outline-google-plus btn-sm d-block w-100" href="#"><span class="fab fa-google-plus-g me-2" data-fa-transform="grow-8"></span> google</a></div>
                                <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100" href="#"><span class="fab fa-facebook-square me-2" data-fa-transform="grow-8"></span> facebook</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDetailer" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="ConfirmationModalDelLabel" aria-hidden="true">
            <!-- <div class="modal fade" id="modalDetailer" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalDetailerLabel" aria-hidden="true"> -->
                <div class="modal-dialog modal-lg mt-6" role="document">
                    <div class="modal-content border-0">
                        <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button></div>
                        <div class="modal-body p-0">
                            <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                                <h4 class="mb-1" id="modalDetailerLabel">Replenish Stock</h4>

                            </div>
                            <div class="p-4">
                                <div class="row">
                                    <div class="col-lg-9"></div>
                                       <div class="">Work in progress</div>
                                       <div class="aa"></div>
                                       <div class="bb"></div>
                                       <div class="bbb"></div>
                                    
                                
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
  

        $(document).on('click', 'tr td #replentrigger', function(xc){
            xc.preventDefault();
           var bulkLoc = $(this).attr('stk_loc');
           var pfLoc = $(this).attr('stk_pf');
           var IDN = $(this).attr('stk_bk_id');
           $('.aa').html("bk loc : " + bulkLoc);
           $('.bb').html("pf loc : " + pfLoc);
           $('.bbb').html("bk id : " + IDN);
            $('#modalDetailer').modal('show');

});


    $(document).ready(function() {

        $('#search-product').on('submit', function(aa) {
            aa.preventDefault();
            // $('#loaderImgx').show();
            var formData = $('#search-product').serialize();

            $.ajax({
                type: "POST",
                data: formData,
                url: "_fetch.php",
                success: function(msg) {
                    $('#fetched-data').html(msg);
                    // $('#loaderImgx').hide();
                }
            });
        });
        
    });
  
</script>