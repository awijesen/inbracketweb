<?php
session_start();

//for the login page
// if(isset($_SESSION['LOGGED']) && $_SESSION['LOGGED'] == 'Logged') {
//   header("Location: ".$_SESSION['TDOMAIN']);
// }

if(isset($_SESSION['LOGGED']) && $_SESSION['LOGGED'] == 'Logged'){ ?>

  <script type="text/javascript">
    var newWnd = window.open($_SESSION['TDOMAIN'], '_blank');
    newWnd.opener = null;
  </script>

<?  }

// only for the sub-domain
// if(isset($_SESSION['LOGGED']) && $_SESSION['LOGGED'] == 'Logged') {
//   header("Location: /p/d");
// }


?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Inbracket | Workspace Login</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicons/favicon.ico">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="assets/js/config.js"></script>
    <script src="vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link href="vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
    <link href="assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
    <link href="assets/css/theme.min.css" rel="stylesheet" id="style-default">
    <link href="assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">
    <link href="assets/css/user.min.css" rel="stylesheet" id="user-style-default">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
      var isRTL = JSON.parse(localStorage.getItem('isRTL'));
      if (isRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>
  </head>


  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <div class="container-fluid">
        <div class="row min-vh-100 flex-center g-0">
          <div class="col-lg-8 col-xxl-5 py-3 position-relative">
            <div class="card overflow-hidden z-index-1">
              <div class="card-body p-0">
                <div class="row g-0 h-100">
                  <div class="col-md-5 text-center bg-card-gradient">
                    <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                      <div class="bg-holder bg-auth-card-shape" style="background-image:url(assets/img/icons/spot-illustrations/half-circle.png);">
                      </div>
                      <!--/.bg-holder-->

                      <div class="z-index-1 position-relative"><a class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder" href="index.html"><img src="assets/img/gallery/inBracket_logo_new.png" style="height:40px"/></a>
                        <p class="opacity-75 text-white">A comprehensive Warehouse Management System designed to automate warehousing processes, thereby increasing operational efficiency and accuracy leading to business growth.</p>
                      </div>
                    </div>
                    <!-- <div class="mt-3 mb-4 mt-md-4 mb-md-5 light">
                      <p class="text-white">Don't have an account?<br><a class="text-decoration-underline link-light" href="p/authentication/card/register.html">Get started!</a></p> -->
                      <!-- <p class="mb-0 mt-4 mt-md-5 fs--1 fw-semi-bold text-white opacity-75">Read our <a class="text-decoration-underline text-white" href="#!">terms</a> and <a class="text-decoration-underline text-white" href="#!">conditions </a></p> -->
                    <!-- </div> -->
                  </div>
                  <div class="col-md-7 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                      <div class="row flex-between-center">
                        <div class="col-auto">
                          <h3>Access Verify</h3>
                        </div>
                      </div> 
                      <form method="POST" id="uf" name="uf" action="">
                        <div class="mb-3">
                          <label class="form-label" for="em">Tennet ID</label>
                          <input class="form-control" id="em" type="text" />
                        </div>
                        <div class="row flex-between-center">
                          <div class="col-auto">
                            <div class="form-check mb-0">
                              <!-- <input class="form-check-input" type="checkbox" id="card-checkbox" checked="checked" /> -->
                              <!-- <label class="form-check-label mb-0" for="card-checkbox">Remember me</label> -->
                            </div>
                          </div>
                          <div class="col-auto"><a class="fs--1" href="#">Forgot ID?</a></div>
                        </div>
                        <div class="mb-3">
                          <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Validate</button>
                        </div>
                      </form> 
                      <div class="errormessage fs--1 font-sans-serif text-danger">&nbsp;</div>
                      <!-- <div class="position-relative mt-4">
                        <hr class="bg-300" />
                        <div class="divider-content-center">or log in with</div>
                      </div> -->
                      <!-- <div class="row g-2 mt-2">
                        <div class="col-sm-6"><a class="btn btn-outline-google-plus btn-sm d-block w-100" href="#"><span class="fab fa-google-plus-g me-2" data-fa-transform="grow-8"></span> google</a></div>
                        <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100" href="#"><span class="fab fa-facebook-square me-2" data-fa-transform="grow-8"></span> facebook</a></div>
                      </div> -->
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
    <script src="vendors/popper/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/anchorjs/anchor.min.js"></script>
    <script src="vendors/is/is.min.js"></script>
    <script src="vendors/fontawesome/all.min.js"></script>
    <script src="vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="vendors/list.js/list.min.js"></script>
    <script src="assets/js/theme.js"></script>

  </body>

</html>

<script>
  $('#uf').submit(function(eh){
    eh.preventDefault();
    // alert('mohanaa');
    
    var _un = $('#em').val();

    $.ajax({
      type: "POST",
      data:{u:_un},
      url: "p/authentication/_auth_tennent.php",
      success: function(returnMessage) {
        if(returnMessage == 'Invalidentries') {
          // $('#em').css("border", "1px solid orange");
             $('.errormessage').html('Invalid tennent ID');
        } else if(returnMessage == 'Nonefound') {
          // $('#card_email').css("border", "1px solid orange");
             $('.errormessage').html('Invalid tennent ID');
        } else if(returnMessage == 'Invalidpassword') {
            $('.errormessage').html('Invalid tennent ID');
        } else {
        //   alert(returnMessage);
            // window.location.href = "https://workspace.inbracket.com";
            window.location.href = "https://" + returnMessage;
            // header( "Location:".returnMessage);
          }
        }
      });

  })
</script>