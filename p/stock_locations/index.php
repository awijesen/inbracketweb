<?php

session_start();
if (!isset($_SESSION['LOGGED'])) {
  header('Location: ../../');
}

date_default_timezone_set('Australia/Darwin');
$actualtime = date("Y-m-d h:i:s", time());

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
        <div class="row">
          <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="card mb-3">
              <!--/.bg-holder-->

              <div class="card-header bg-light">
                <div class="row justify-content-between align-items-center">
                  <div class="col-10">
                    <div class="row">
                      <div class="col-12">
                        <h5 class="card-header-title mb-0 col-12">Stock Locations</h5>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="col-2 ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as read</a></div> -->
                </div>
              </div>
              <div class="card-body position-relative" style="min-height: 300px !important">
                <!-- Body -->
                <div class="row">
                  <div class="col-4 form-group">
                    <label for="prod">Product Code</label>
                    <select class="form-select selectpicker fs--1 mb-0 font-sans-serif" name="prod" id="prod" style="width:100%;">
                      <option class="fs--1 mb-0 font-sans-serif" value="selectproduct">Select</option>
                      <?php
                      require(__DIR__ . '../../../dbconnect/db.php');

                      $sql = "SELECT distinct(ProductCode) as 'ProductCode', ProductDescription FROM INB_PRODUCT_MASTER ORDER BY ProductCode ASC";

                      $stmt = $conn->prepare($sql);
                      $stmt->execute();
                      $result = $stmt->get_result();

                      if (mysqli_num_rows($result) > 0) {
                        while ($row = $result->fetch_assoc()) {
                          echo '<option value=' . $row["ProductCode"] . '>' . $row["ProductCode"] . ' - ' . $row["ProductDescription"] . '</option>';
                        }
                      } else {
                        echo "error";
                      }    ?>

                    </select>

                  </div>
                  <div class="col-4">
                    <label for="loca">Pickface</label>
                    <select class="form-select selectpicker" name="loca" id="loca" style="width:100%; font-family: 'Poppins' !important;">
                      <option value="selectloc">Select</option>
                      <?php
                      require(__DIR__ . '../../../dbconnect/db.php');

                      $sql = "SELECT StockLocation FROM INB_STOCK_LOC_MAINTAIN WHERE LocationClassification='Pick Face' ORDER BY StockLocation ASC;";

                      $stmt = $conn->prepare($sql);
                      $stmt->execute();
                      $result = $stmt->get_result();

                      if (mysqli_num_rows($result) > 0) {
                        while ($row = $result->fetch_assoc()) {
                          echo '<option value=' . $row["StockLocation"] . '>' . $row["StockLocation"] . '</option>';
                        }
                      } else {
                        echo "error";
                      }    ?>

                    </select>

                  </div>

                  <!-- <div class="col-4">
                <label for="locas">Pickfacexx</label>
                <select class="form-select selectpicker" name="locas" id="locas" style="width:100%; font-family: 'Poppins' !important;">
                  <option value="selectloc">Select</option>
                  <?php
                  require(__DIR__ . '../../../dbconnect/db.php');

                  $sql = "SELECT StockLocation FROM INB_STOCK_LOC_MAINTAIN WHERE LocationClassification='Pick Face' ORDER BY StockLocation ASC;";

                  $stmt = $conn->prepare($sql);
                  $stmt->execute();
                  $result = $stmt->get_result();

                  if (mysqli_num_rows($result) > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo '<option value=' . $row["StockLocation"] . '>' . $row["StockLocation"] . '</option>';
                    }
                  } else {
                    echo "error";
                  }    ?>

                </select>

              </div> -->


                  <div class="col-4">
                    <input type="button" class="btn btn-falcon-primary btn-sm" id="add_loc" value="Create Pickface" style="margin-top: 32px !important">
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 mt-2 font-sans-serif fs--1" id="alert-msg" style="color:var(--falcon-red); margin-top: 6px;"></div>
                </div>
                <!-- close body -->
              </div>
            </div>
          </div>

          <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="card mb-3">
              <!--/.bg-holder-->

              <div class="card-header bg-light">
                <div class="row justify-content-between align-items-center">
                  <div class="col-10">
                    <div class="row">
                      <div class="col-12">
                        <h5 class="card-header-title mb-0 col-12">Location Label Print</h5>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="col-2 ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as read</a></div> -->
                </div>
              </div>
              <div class="card-body position-relative" style="min-height: 300px !important">
                <div class="row">
                  <div class="col-lg-12 col-md-12 d-flex flex-row">
                    <div>
                      <label for="pf">Bin Location</label>
                      <!-- <div class="col-md-12 col-sm-12 col-xs-12 d-flex flex-row"> -->
                      <input type="hidden" id="reason_hidden" name="reason_hidden" style="height: 60px !important;">
                      <select name="pf" id="pf" class="form-select form-select-sm">
                        <option value="selectloc">Select</option>
                        <?php
                        require(__DIR__ . '../../../dbconnect/db.php');

                        $sql = "SELECT StockLocation from INB_STOCK_LOC_MAINTAIN ORDER BY StockLocation ASC";

                        $stmt = $conn->prepare($sql);
                        // $stmt->bind_param("s", $search);
                        // $search = $findOrder;
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if (mysqli_num_rows($result) > 0) {
                          while ($row = $result->fetch_assoc()) {
                            echo '<option value=' . $row["StockLocation"] . '>' . $row["StockLocation"] . '</option>';
                          }
                        } else {
                          echo "error";
                        }    ?>

                      </select>
                    </div>
                    <div>
                      <button id="print_loc" name="print_loc" type="button" class="btn btn-falcon-primary btn-sm ms-2" style="margin-top: 32px !important">Generate&nbsp;Label</button>
                    </div>
                    <div id="print_link" class="mt-4 pt-1 ps-3"></div>
                  </div>
                </div>
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

    $('#loca').select2();
    $('#prod').select2();

    // $('#locas').select2({
    //     ajax: {
    //       url: 'https://api.github.com/search/repositories',
    //       dataType: 'json'
    //       // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    //     }
    //   })

    $('#add_loc').on('click', function(cl) {
      cl.preventDefault();

      var ProductCode = $('#prod').val();
      var Pickface = $('#loca').val();

      if (ProductCode == 'selectproduct') {
        $('#alert-msg').html('Select product');
      } else if (Pickface == 'selectloc') {
        $('#alert-msg').html('Select pickface');
      } else {
        $('#alert-msg').html('');
        $.ajax({
          type: "POST",
          url: "_validate.php",
          data: {
            ProductCode: ProductCode,
            Pickface: Pickface
          },
          success: function(msgx) {
            $('#alert-msg').html(msgx);
          }
        })
      }
    })
  });

  $('#print_loc').on('click', function(cb) {
    cb.preventDefault();

    var loc = $('#pf option:selected').val();

    if (loc === 'selectloc') {
      alert('Please select a bin location');
    } else {
      $('#print_link').html("<a id='lblPrint' class='fs--1 font-sans-serif' style='margin-top:32px;' rel='noopener noreferrer' href='../bin_label?link=" + loc + "' target='_blank'>Print</a>");
    }
  });

  $('#lblPrint').on('click', function(fd){
    fd.preventDefault();
alert('dfsdfdsf');
    $('#lblPrint').hide();
    $('#pf').prop('selectedIndex', 0);
  })
</script>