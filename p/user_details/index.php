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
                  <div class="row">
                    <div class="col-1">
                      <a id="closebtn_" class="btn btn-primary btn-sm" style="background-color: var(--falcon-blue)">Close</a>
                    </div>
                    <div class="col-5">
                      <h5 class="card-header-title mb-0">User Details</h5>
                    </div>
                  </div>
                </div>
              </div>
              <!-- <div class="col-2 ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as read</a></div> -->
            </div>
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

                <table id="orderpick_details" class="table table-striped table-hover dt-responsive display compact font-sans-serif fs--2 custFontSize" style="width: 100% !important">
                  <thead style="font-family: 'Poppins'; font-size: 13px">
                    <th>First&nbsp;Name</th>
                    <th>Last&nbsp;Name</th>
                    <th>User&nbsp;Code</th>
                    <th>User&nbsp;Id</th>
                    <th>Email</th>
                    <th>Role</th>
                    <!-- <th>Login&nbsp;Status</th> -->
                    <th>Last&nbsp;Login</th>
                    <th>Active&nbsp;Status</th>
                  </thead>
                  <tbody style="font-family: 'Poppins'; font-size: 13px">
                  </tbody>
                </table>
              </div>
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
      }],
      'lengthMenu': [
        [20, 30, 50, 100, -1],
        [20, 30, 50, 100, 'All']
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
      'length': 20,
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
          'targets': [0, 1],
          'orderable': false
        },
        {
          "targets": [2, 7], // your case first column
          "className": "text-center"
        }
      ],
      "language": {
        'info': '_START_ to _END_ of _TOTAL_ users',
        'infoEmpty': 'Showing 0 to 0 of 0 users',
        'infoFiltered': '',
        'sLengthMenu': '_MENU_'
      }
    });

    inprogressTabledata = $("#orderpick_details").DataTable();

    inprogressTabledata.buttons().container().appendTo('#exporter');
    $('#filterRecs_InProgress').on('change', function(ef) {
      ef.preventDefault();
      var optVal = $('#filterRecs_InProgress').val();
      inprogressTabledata.page.len(optVal).draw();
      // alert(optVal);
    });


    inprogressTabledata = $("#orderpick_details").DataTable();
    new $.fn.dataTable.Buttons(inprogressTabledata, {
      'buttons': [{
        'extend': 'collection',
        'className': 'btn btn-primary btn-sm',
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

    inprogressTabledata.buttons().container().appendTo('#exporter');

    $('#search').on('keyup', function() {
      inprogressTabledata.search(this.value).draw();
      inprogressTabledata.state.save();
    });

    inprogressTabledata.buttons().container().appendTo('#exporter');
    $('#filterRecs_InProgress').on('change', function(ef) {
      ef.preventDefault();
      var optVal = $('#filterRecs_InProgress').val();
      inprogressTabledata.page.len(optVal).draw();
      // alert(optVal);
    })

    $('#closebtn_').on('click', function(xc) {
      xc.preventDefault();
      window.top.close();
    })

  });
</script>