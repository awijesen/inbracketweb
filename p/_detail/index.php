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
          <div class="card-header bg-light">
            <div class="row justify-content-between align-items-center">
              <div class="col-10">
                <div class="row">
                  <div class="row">
                    <div class="col-1">
                      <a href="../pick_review/" class="btn btn-primary btn-sm" style="background-color: var(--falcon-blue)">Back</a>
                    </div>
                    <div class="col-5">
                      <h5 class="card-header-title mb-0">Picked Line Details</h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-2 ps-0 ps-sm-3"><a class="card-link fw-normal" id="reassign_order" href="#">Re-assign Order</a></div>
            </div>
          </div>
          <div class="card-body position-relative">
            <!-- start -->
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
                      <div class='col-lg-5 col-sm-12'>
                      <label for='storeName' class='form-label'>Customer</label>
                      <div class='col-12 fnt s13' id='storeName'>" . $row['OrderCustomer'] . "</div>
                      </div>
                    </div>
                    </div>";
              }

              ?>

              <div class="row">
                <div class="row col-md-12 d-flex justify-content-end">
                  <div class="d-flex justify-content-end col-md-5">
                    <div class="d-flex col-4 justify-content-end px-3" id="exporter"></div>
                    <div class="col-4">
                      <select class="form-select form-select-sm" name="filterRecs_InProgress" id="filterRecs_InProgress" style="padding-right:2px; background-position: top 8px right 4px">
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="1000000000">All</option>
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

              <table id="orderpick_details_table" class="table table-stripe table-hover dt-responsive display compact fs--2" style="width: 100% !important">
                <thead style="font-family: 'Poppins'; font-size: 13px">
                  <th>Product&nbsp;Code</th>
                  <th>Description</th>
                  <th>Order&nbsp;Qty</th>
                  <th>Picked&nbsp;Qty</th>
                  <th>Reason&nbsp;Code</th>
                  <th>Picked&nbsp;On</th>
                  <th>Picked&nbsp;By</th>
                </thead>
                <tbody style="font-family: 'Poppins'; font-size: 13px">
                </tbody>
                <!-- end table -->
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

    <div class="modal fade" id="ConfirmationModalDel" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="ConfirmationModalDelLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
          <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" id="ConfirmationModalDelClose" aria-label="Close"></button></div>
          <div class="modal-body p-0">
            <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
              <h4 class="mb-1" id="ConfirmationModalDelLabel">Confirmation</h4>
              <!-- <p class="fs--2 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
            </div>
            <div class="p-4">
              <div class="row">
                <div class="col-lg-12">
                  <!-- <div class="d-flex"> -->
                  <div class="flex-1">
                    <h5 class="mb-2 fs-0">Are you sure you want to delete the picked line?</h5>
                    <input type="text" name="identity_del" id="identity_del">
                    <input type="text" name="identity_code" id="identity_code">
                    <input type="text" name="identity_qty" id="identity_qty">
                  </div>
                  <!-- </div> -->
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="deleteconfirm">Confirm</button>
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
                    <h5 class="mb-2 fs-0">Are you sure you want to re-assign the order?</h5>
                    <input type="hidden" name="identity_del" id="identity_del">
                    <input type="hidden" name="identity_code" id="identity_code">
                    <input type="hidden" name="identity_qty" id="identity_qty">
                  </div>
                  <!-- </div> -->
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="_confirm">Confirm</button>
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
    $('#orderpick_details_table').DataTable({
      stateSaveParams: function(settings, data) {
        data.searchCountry = $('#search').val();
      },
      stateLoadParams: function(settings, data) {
        $('#search').val(data.searchCountry);
      },
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
          // action: function ( e, dt, node, config ) {
          //     alert( 'Button activated' );
          // }
        }


      ],
      'lengthMenu': [
        [10, 30, 50, 100, -1],
        [10, 30, 50, 100, 'All']
      ],
      'stateSave': 'true',
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
        [4, 'desc']
      ],
      "columnDefs": [{
          'targets': [0],
          'orderable': false
        },
        {
          "targets": [2, 3, 6], // your case first column
          "className": "text-center"
        }
      ],
      "language": {
        "info": "_PAGE_ of _PAGES_ pages",
        "infoFiltered": ""
      }
    });

    inprogressTabledataPushBack = $("#orderpick_details_table").DataTable();

    inprogressTabledataPushBack.buttons().container().appendTo('#exporter');
    $('#filterRecs_InProgress').on('change', function(ef) {
      ef.preventDefault();
      var optVal = $('#filterRecs_InProgress').val();
      inprogressTabledataPushBack.page.len(optVal).draw();
      // alert(optVal);
    });

    new $.fn.dataTable.Buttons(inprogressTabledataPushBack, {
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
      inprogressTabledataPushBack.search(this.value).draw();
      inprogressTabledataPushBack.state.save();
    });

    $('#refresh_btn_id').on('click', function(re) {
      re.preventDefault();
      $('#orderpick_details_table').DataTable().ajax.reload();
    })


    $('#orderpick_details_table').on('click', '.delete_this_item', function(ds) {
      // $('#delete_this').on('click', function(ds) {
      ds.preventDefault();
      // var vals = $(this).attr('id');

      $('#identity_del').val($(this).attr("id"));
      $('#identity_code').val($(this).attr("code"));
      $('#identity_qty').val($(this).attr("qty"));
      $('#ConfirmationModalDel').modal('show');
      // $('#ConfirmationModalDel').modal('show');
    })

  $('#reassign_order').on('click', function(io) {
      // $('#delete_this').on('click', function(ds) {
      io.preventDefault();
      // var vals = $(this).attr('id');
      // alert(vals);
      // $('#identity_del').val($(this).attr("id"));
      // $('#identity_code').val($(this).attr("code"));
      // $('#identity_qty').val($(this).attr("qty"));
      $('#ConfirmationModal').modal('show');
  
  })

  $('#reasonmodalclose').on('click', function(aw) {
      aw.preventDefault();
      $('#ConfirmationModal').modal('hide');
    })

    $('#_confirm').on('click', function(gcz) {
      gcz.preventDefault();

      var clickId = '<?= $orderToFetch ?>';
 
      // alert(clickId);
      $.ajax({
        url: "_reassign.php", //the page containing php script
        type: "POST", //request type,
        data: {
          link: clickId
        },
        success: function(result) {
          $('#ConfirmationModal').modal('hide');
          window.location.replace("https://workspace.inbracket.com/p/pick_review/");
        }
      });
    });


  });
</script>