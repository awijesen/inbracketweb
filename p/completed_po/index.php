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

        <div class="card mb-3">
          <!--/.bg-holder-->
          <div class="card-header bg-light">
            <div class="row justify-content-between align-items-center">
              <div class="col-10">
                <div class="row">
                  <div class="col-6">
                    <h5 class="card-header-title mb-0 col-12">Completed Purchase Orders</h5>
                  </div>
                </div>
              </div>
              <!-- <div class="col-2 ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as read</a></div> -->
            </div>
          </div>
          <div class="card-body position-relative">
            <!-- Body -->
            <form action="" method="POST" name="_as_po" id="_as_po">
              <div class="container-fluid">
                <div class="row">

                  <div class="col-lg-2 col-md-2 col-sm-10 col-xs-10 pe-0">
                  <select name="_ureceiver" id="_ureceiver" class="form-select form-select-sm">
                      <option value="selectpicker">Select Receiver</option>
                      <?php
                      require(__DIR__ . '../../../dbconnect/db.php');

                      $sql = "SELECT * FROM INB_USERMASTER ORDER BY fname asc";

                      $stmt = $conn->prepare($sql);
                      // $stmt->bind_param("s", $search);
                      // $search = $findOrder;
                      $stmt->execute();
                      $result = $stmt->get_result();

                      if (mysqli_num_rows($result) > 0) {
                        while ($row = $result->fetch_assoc()) {
                          echo '<option value=' . $row["UserCode"] . '>' . $row["fname"] . " " . $row["lname"] . '</option>';
                        }
                      } else {
                        echo "error";
                      }    ?>

                    </select>
                  </div>
                  <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
                    <button id="_assign_ord_po" type="button" class="btn btn-falcon-primary btn-sm">Reopen&nbsp;and&nbsp;Assign</button>
                  </div>
                  <div class="row col-md-9 d-flex justify-content-end">
                    <div class="col-md-4 d-flex justify-content-end">
                      <!-- <button class="ml-2 btn btn-falcon-default btn-sm" id="refresh_btn_id2">Fetch&nbsp;New</button> -->
                    </div>
                    <div class="d-flex justify-content-end col-md-5">
                    <!-- <button class="ml-2 btn btn-falcon-default btn-sm me-3" id="">Reopen</button> -->
                      <button class="ms-2 me-2 btn btn-falcon-default btn-sm me-3" id="refresh_btn_id">Refresh</button>
                      <div class="me-2" id="exporter"> </div>
                      <select class="form-select form-select-sm" name="filterRecs_InProgress" id="filterRecs_InProgress" style="padding-right:2px; background-position: top 8px right 4px">
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="1000000000">All</option>
                      </select>
                     
                    </div>
                    <div class="col-md-3">
                      <div class="input-group input-group-sm">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                        <input id="search" type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="font-sans-serif fs--1 text-warning pt-1" id="_em">&nbsp</div>
                </div>

                <table id="assign_po_table" class="table table-striped table-hover dt-responsive display compact font-sans-serif fs--1 custFontSize" style="width: 100% !important">
                  <thead>
                    <tr>
                      <th>...</th>
                      <th>Purchase&nbsp;Order</th>
                      <th>Vendor</th>
                      <th>Assigned&nbsp;By</th>
                      <th>Assigned&nbsp;On</th>
                      <th>Receiver</th>
                      <th>Tot&nbsp;Lines</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </form>


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

    $('#assign_po_table').DataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'pageLength': 20,
      'stateSave': true,
      stateSaveParams: function(settings, data) {
        data.searchCountry = $('#search').val();
      },
      stateLoadParams: function(settings, data) {
        $('#search').val(data.searchCountry);
      },
      'dom': 'Brt<ip>',
      'buttons': [{
          extend: 'collection',
          className: 'btn btn-falcon-primary btn-sm',
          text: 'Export',
          buttons: [
            'copy',
            'excel',
            'csv',
            'pdf',
            'print'
          ]
        },
        // {
        //   text: 'Refresh',
        //   className: 'btn-falcon-primary btn-sm refresh_btn_id',
        //   attr: {
        //     id: 'refresh_btn_id'
        //   }
        //   // action: function ( e, dt, node, config ) {
        //   //     alert( 'Button activated' );
        //   // }
        // }


      ],
      'lengthMenu': [
        [10, 25, 50, 100, 100000000],
        [10, 25, 50, 100, 'All']
      ],
      'ajax': {
        'url': 'datatable.php'
      },
      'order': [
        [2, 'desc']
      ],
      'columns': [
        {
          data: 'selector'
        },
        {
          data: 'PONumber'
        },
        {
          data: 'VendorName'
        },
        {
          data: 'AssignedBy'
        },
        {
          data: 'AssignedOn'
        },
        {
          data: 'Receiver'
        },
        {
          data: 'lines'
        }
      ],
      'columnDefs': [
        {
          orderable: false,
          targets: [0, 6]
        },
      { "targets": 6, // your case first column
        "className": "text-center"
      },
      {
          "targets": [3, 4],
          "className": "text-nowrap"
        }],
      'responsive': 'true',
      'responsive': {
        details: {
          type: 'none'
        }
      },
      'language': {
        'info': '_START_ to _END_ of _TOTAL_ orders',
        'infoEmpty': 'Showing 0 to 0 of 0 scans',
        'infoFiltered': '(filtered from _MAX_ total orders)',
        'sLengthMenu': '_MENU_'
        // "infoFiltered":""
      },
      "footerCallback": function(row, data, start, end, display) {
        var api = this.api(),
          data;
        // Remove the formatting to get integer data for summation
        var intVal = function(i) {
          return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
        };

        // total_salary over all pages
        // total_salary = api.column( 5 ).data().reduce( function (a, b) {
        //   return intVal(a) + intVal(b);
        // },0 );

        // total_order_value over this page
        total_order_value = api.column(5, {
          page: 'current'
        }).data().reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

        total_order_value = parseFloat(total_order_value);
        // total_salary = parseFloat(total_salary);
        // Update footer
        $('#totalOrderVal').html(total_order_value.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));

      }
    });

    inprogressTable = $("#assign_po_table").DataTable();
    new $.fn.dataTable.Buttons(inprogressTable, {
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

    inprogressTable.buttons().container().appendTo('#exporter');

    $('#search').on('keyup', function() {
      inprogressTable.search(this.value).draw();
      inprogressTable.state.save();
    });

    $('#filterRecs_InProgress').on('change', function(ef) {
      ef.preventDefault();
      var optVal = $('#filterRecs_InProgress').val();
      inprogressTable.page.len(optVal).draw();
      // alert(optVal);
    });

    $('#_assign_ord_po').on('click', function(ef) {
    ef.preventDefault();
    var fd = $('#_as_po').serialize();
    $.ajax({
      type: "POST",
      data: $('#_as_po').serialize(),
      url: "itry.php",
      success: function(msgx) {
        $resp = msgx.substring(0, 12);
        if ($resp == 'success-dsds') {
          $('#_em').html(msgx);
          $('#_ureceiver').prop('selectedIndex', 0);
          $('#assign_po_table').DataTable().ajax.reload();
        } else if (msgx.substring(0, 3) == 'Sel') {
          $('#_em').html(msgx);
        } else if (msgx.substring(0, 3) == 'Ord') {
          $('#_em').html(msgx);
        } else {
          $('#_em').html(msgx);
          $('#_ureceiver').prop('selectedIndex', 0);
          $('#assign_po_table').DataTable().ajax.reload();
        }
      }
    })
  });

  $('#refresh_btn_id2').on('click', function() {
    $('#spinner-class').show();
    $.ajax({
      type: "POST",
      url: "../../INB_OUT/API/GRWILLS/_fetch_po.php",
      success: function(msgx) {
        if (msgx === 'Loaded') {
          $('#spinner-class').hide();
          $('#assign_ord_po').DataTable().ajax.reload();
        } else {
          $('#spinner-class').hide();
        }
      }
    })
  });

  $('#refresh_btn_id').on('click', function() {
      $('#assign_ord_po').DataTable().ajax.reload();
  });

  });
</script>