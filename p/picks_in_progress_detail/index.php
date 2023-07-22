<?php

session_start();
if (!isset($_SESSION['LOGGED'])) {
  header('Location: ../../');
}

$orderToFetch = htmlspecialchars($_GET['link']);

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

        <div class="card mb-3">
          <!--/.bg-holder-->
          <div class="card-header bg-light d-flex flex-row">
            <!-- <div class="row"> -->
            <!-- <div class="col-md-12"> -->
            <!-- <div class="row"> -->
            <!-- <div class="row"> -->
            <div class="col-md-1">
              <a href="../picks_in_progress/" class="btn btn-primary btn-sm" style="background-color: var(--falcon-blue)">Back</a>
            </div>
            <div class="col-md-5 flex-row justify-content-start">
              <h5 class="card-header-title mb-0">Picks in Progress Details</h5>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-1 d-flex justify-content-end pe-2 pt-1"><img id="tick-marked" src="../../assets//img/icons/accept.png" height="20" alt="reassigned"></div>
            <div class="col-md-3 d-flex flex-row justify-content-end">
              <div class="col-md-9 d-flex flex-row">
                <input type="hidden" id="reason_hidden" name="reason_hidden" style="height: 60px !important;">
                <select name="_upkr" id="_upkr" class="form-select form-select-sm">
                  <option value="selectpicker">Select Picker</option>
                  <?php
                  require(__DIR__ . '../../../dbconnect/db.php');

                  $sql = "SELECT * FROM INB_USERMASTER ORDER BY fname ASC";

                  $stmt = $conn->prepare($sql);
                  // $stmt->bind_param("s", $search);
                  // $search = $findOrder;
                  $stmt->execute();
                  $result = $stmt->get_result();

                  if (mysqli_num_rows($result) > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo '<option value=' . $row["UserCode"] . '>' . $row["fname"] . ' ' . $row["lname"] . '</option>';
                    }
                  } else {
                    echo "error";
                  }    ?>

                </select>
              </div>
              <div class="col-md-3 col-sm-2 col-xs-2">
                <button id="_reassign_ord" type="button" class="btn btn-primary btn-sm ms-2">Assign</button>
              </div>
              <!-- <div style="margin-left: 30px;"><img src="../../assets//img/icons/accept.png" height="20" alt="reassigned"></div> -->
            </div> <!-- assign order close- -->

            <!-- </div> -->
            <!-- </div> -->
            <!-- </div> -->
            <!-- </div> -->


          </div>
          <div class="card-body position-relative card-body-inner">
            <!-- start -->
            <div>
              <?php
              require('../../dbconnect/db.php');

              $sql = "SELECT distinct(OrderCustomer), OrderValue as 'Val', Reference as 'Ref' FROM GRW_INB_SALES_ORDERS WHERE SalesOrderNumber=? group by SalesOrderNumber";
              $stmt = $conn->prepare($sql);
              $stmt->bind_param("s", $orderToFetch);
              $stmt->execute();
              $result = $stmt->get_result();
              while ($row = $result->fetch_assoc()) {
                echo "
                    <div class='col-lg-12' style='padding: 1.25rem'>
                      <div class='row'>
                      <div class='col-lg-2 col-sm-12'>
                      <label for='orderNumber' class='form-label'>Sales Order Number</label>
                      <div class='col-12 fnt s13' id='orderNumber'>" . $orderToFetch . "</div>
                      </div>
                      <div class='col-lg-2 col-sm-12'>
                      <label for='referenceOrd' class='form-label'>Reference</label>
                      <div class='col-12 fnt s13' id='referenceOrd'>" . $row['Ref'] . "</div>
                      </div>
                      <div class='col-lg-2 col-sm-12'>
                      <label for='OrdVal' class='form-label'>Value</label>
                      <div class='col-12 fnt s13' id='OrdVal'>" . $row['Val'] . "</div>
                      </div>
                      <div class='col-lg-5 col-sm-12'>
                      <label for='storeName' class='form-label'>Customer</label>
                      <div class='col-12 fnt s13' id='storeName'>" . $row['OrderCustomer'] . "</div>
                      </div>
                    </div>
                    </div>";
              }

              ?>

              <div class="col-lg-12" style="padding: 1.25rem">
                <!-- table here -->
                <div class="row">
                  <div class="row col-md-12 d-flex justify-content-end">
                    <div class="d-flex justify-content-end col-md-6">
                      <div class="d-flex col-4 justify-content-end px-3" id="exporter"></div>
                      <div class="col-4">
                        <select class="form-select form-select-sm" name="filterRecs_InProgress" id="filterRecs_InProgress" style="padding-right:2px; background-position: top 8px right 4px">
                          <option value="20">20</option>
                          <option value="30">30</option>
                          <option value="50">50</option>
                          <option value="100">100</option>
                          <option value="-1">All</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="input-group input-group-sm">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                        <input id="search" type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                      </div>
                    </div>
                  </div>
                </div>

                <table id="orderpick_details" class="table table-striped table-hover dt-responsive display compact font-sans-serif fs--1 custFontSize">
                  <thead style="font-family: 'Poppins'; font-size: 13px">
                    <th>Product&nbsp;Code</th>
                    <th>Description</th>
                    <th>Order&nbsp;Qty</th>
                    <th>Picked&nbsp;Qty</th>
                    <th>Reason&nbsp;Code</th>
                    <th>Picked&nbsp;On</th>
                    <th>Picked&nbsp;By</th>
                    <th>. . .</th>
                  </thead>
                  <tbody style="font-family: 'Poppins'; font-size: 13px">
                  </tbody>
                  <!-- end table -->
              </div>
            </div>
            <!-- end -->
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

    <div class="modal fade" id="ConfirmationModal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="ConfirmationModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
          <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" id="reasonmodalclose" aria-label="Close"></button></div>
          <div class="modal-body p-0">
            <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
              <h4 class="mb-1" id="ConfirmationModalLabel">Confirmation</h4>
              <!-- <p class="fs--2 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
            </div>
            <div class="p-4">
              <div class="row">
                <div class="col-lg-12">
                  <!-- <div class="d-flex"> -->
                  <div class="flex-1">
                    <h5 class="mb-2 fs-0">Are you sure you want to delete the picked line?</h5>
                    <input type="hidden" name="identity_del" id="identity_del">
                    <input type="hidden" name="identity_code" id="identity_code">
                    <input type="hidden" name="identity_qty" id="identity_qty">
                    <input type="hidden" name="identity_price" id="identity_price">
                    <input type="hidden" name="identity_order" id="identity_order">
                  </div>
                  <!-- </div> -->
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="cleanmereason">Confirm</button>
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
    $('#tick-marked').hide();

    $('#orderpick_details').DataTable({
      'dom': '<<B>rt<ip>>',
      'buttons': [{
          extend: 'collection',
          className: 'btn btn-falcon-default btn-sm',
          text: 'Export',
          buttons: [
            'copy',
            'excel',
            'csv',
            'pdf',
            'print'
          ]
        },
        {
          text: 'Refresh',
          className: 'btn btn-falcon-default btn-sm refresh_btn_id',
          attr: {
            id: 'refresh_btn_id'
          }
        }


      ],
      'lengthMenu': [
        [10, 30, 50, 100, -1],
        [10, 30, 50, 100, 'All']
      ],
      'stateSave': 'true',
      stateSaveParams: function(settings, data) {
        data.searchCountry = $('#search').val();
      },
      stateLoadParams: function(settings, data) {
        $('#search').val(data.searchCountry);
      },
      'autoWidth': 'true',
      'responsive': 'true',
      "lengthChange": false,
      "fnCreatedRow": function(nRow, aData, iDataIndex) {
        $(nRow).attr('id', aData[0]);
      },
      "serverSide": true,
      'processing': 'true',
      'paging': 'true',
      'length': 10,
      'destroy': 'true',
      'ajax': {
        'url': './mfetch.php',
        'type': 'post',
        'data': {
          'links': '<?= $orderToFetch ?>'
        }
      },
      "order": [
        [5, 'desc']
      ],
      "columnDefs": [{
          'targets': [0],
          'orderable': false
        },
        {
          "targets": [2, 3], // your case first column
          "className": "text-center"
        }
      ],
      "language": {
        "info": "_PAGE_ of _PAGES_ pages",
        "infoFiltered": ""
      }
    });

    inprogressTableDetail = $("#orderpick_details").DataTable();

    inprogressTableDetail.buttons().container().appendTo('#exporter');

    inprogressTableDetail = $("#orderpick_details").DataTable();
    new $.fn.dataTable.Buttons(inprogressTableDetail, {
      'buttons': [{
        'extend': 'collection',
        'text': 'Export',
        'buttons': [
          'copy',
          'excel',
          'csv',
          'pdf',
          'print'
        ]
      }]
    })

    $('#search').on('keyup', function() {
      inprogressTableDetail.search(this.value).draw();
      inprogressTableDetail.state.save();
    });

    $('#filterRecs_InProgress').on('change', function(ef) {
      ef.preventDefault();
      var optVal = $('#filterRecs_InProgress').val();
      inprogressTableDetail.page.len(optVal).draw();
      // alert(optVal);
    });

    $('#refresh_btn_id').on('click', function(re) {
      re.preventDefault();
      $('#orderpick_details').DataTable().ajax.reload();
    })

    $('#orderpick_details').on('click', '.delete_this', function(ds) {
      // $('#delete_this').on('click', function(ds) {
      ds.preventDefault();
      // var vals = $(this).attr('id');
      // alert(vals);
      $('#identity_del').val($(this).attr("id"));
      $('#identity_code').val($(this).attr("code"));
      $('#identity_qty').val($(this).attr("qty"));
      $('#identity_price').val($(this).attr("pricetag"));
      $('#identity_order').val($(this).attr("sonum"));
      $('#ConfirmationModal').modal('show');
    })

    // $('#staticBackdrop').on('shown.bs.modal', function(bsmx) {
    //   bsmx.preventDefault();
    //   $('#reasoncode').val('');
    //   $('.errMsg11').html('');
    //   $('#reason_hidden').val('');
    // });

    $('#reasonmodalclose').on('click', function(aw) {
      aw.preventDefault();
      $('#ConfirmationModal').modal('hide');
    })

    // $('#cleanmereason').on('click', function(gcz) {
    //   gcz.preventDefault();
    //   var shenu = '<?php echo "-" . $_SESSION['UCODE'] . ", " . date("D M d, Y G:i") ?>';
    //   $('#orderpick_details').DataTable().ajax.reload();
    //     $('#ConfirmationModal').modal('hide');

    // })


    $('#cleanmereason').on('click', function(gcz) {
      gcz.preventDefault();

      var clickId = $('#identity_del').val();
      var clickCode = $('#identity_code').val();
      var clickQty = $('#identity_qty').val();
      var clickPrice = $('#identity_price').val();
      var clickOrder = $('#identity_order').val();

      $.ajax({
        url: "_remove_line.php", //the page containing php script
        type: "POST", //request type,
        data: {
          link: clickId,
          pCode: clickCode,
          pQty: clickQty,
          sorder: clickOrder,
          price: clickPrice
        },
        success: function(result) {
          $('#orderpick_details').DataTable().ajax.reload();
          $('#ConfirmationModal').modal('hide');
        }
      });
    });

    $('#_reassign_ord').on('click', function(ef) {
      ef.preventDefault();
      // var fd = $('#_as_fm').serialize();
      var gb = $('#_upkr').val();
      var OrdNum = '<?= $orderToFetch ?>';
      // var gg = $('#reason_hidden').val();
      // alert(gb);
      // alert(gg);

      $.ajax({
        type: "POST",
        // data: $('#_as_fm').serialize(),
        data: {
          PickerVal: gb,
          OrderVal: OrdNum
        },
        url: "_reassign_picker.php",
        success: function(msgx) {
          if (msgx > 0) {
            $('#tick-marked').show();
          } else {
            $('#tick-marked').hide();
          }
          // alert(msgx);
          // $resp = msgx.substring(0, 12);
          // if ($resp == 'success-dsds') {
          //   $('#_em').html(msgx);
          //   $('#_upkr').prop('selectedIndex', 0);
          //   $('#jquery-datatable-ajax-php').DataTable().ajax.reload();
          // } else if (msgx.substring(0, 3) == 'Sel') {
          //   $('#_em').html(msgx);
          // } else if (msgx.substring(0, 3) == 'Ord') {
          //   $('#_em').html(msgx);
          // } else {
          //   $('#_em').html(msgx);
          //   $('#_upkr').prop('selectedIndex', 0);
          //   $('#reason_hidden').val('');
          //   $('#jquery-datatable-ajax-php').DataTable().ajax.reload();
          // }
        }
      })
    });

  });
</script>