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
                  <div class="col-12">
                    <h5 class="card-header-title mb-0 col-12">Product Master</h5>
                  </div>
                </div>
              </div>
              <!-- <div class="col-2 ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as read</a></div> -->
            </div>
          </div>
          <div class="card-body position-relative">
            <!-- Body -->
            <div class="row">
            <div class="row">
                  <div class="col-lg-3 col-md-4 d-flex flex-row">
                    
                  </div>
                  <div class="row col-lg-9 col-md-8 d-flex justify-content-end">
                    <div class="col-md-6 col-sm-12 col-xs-12 d-flex justify-content-end">
                      <!-- <div class="col-md-4"> -->
                        <!-- fetch start -->
                        <!-- <div class="col-md-4 d-flex flex-row"> -->
                          <!-- fetch new start -->
                          <button class="ml-2 btn btn-falcon-default btn-sm me-2" id="refresh_btn_id2"><i class="fa-solid fa-rotate"></i></button>
                          <!-- FETCH SPINNER OPEN -->
                          <div class="">
                            <div id="spinner-class">
                              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:transparent;display:block;" width="80px" height="20px" viewBox="0 0 70 70" preserveAspectRatio="xMidYMid">
                                <circle cx="84" cy="50" r="10" fill="#e1e7e7">
                                  <animate attributeName="r" repeatCount="indefinite" dur="0.25s" calcMode="spline" keyTimes="0;1" values="10;0" keySplines="0 0.5 0.5 1" begin="0s"></animate>
                                  <animate attributeName="fill" repeatCount="indefinite" dur="1s" calcMode="discrete" keyTimes="0;0.25;0.5;0.75;1" values="#e1e7e7;#0a69aa;#07abcc;#91bcc6;#e1e7e7" begin="0s"></animate>
                                </circle>
                                <circle cx="16" cy="50" r="10" fill="#e1e7e7">
                                  <animate attributeName="r" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="0;0;10;10;10" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="0s"></animate>
                                  <animate attributeName="cx" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="16;16;16;50;84" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="0s"></animate>
                                </circle>
                                <circle cx="50" cy="50" r="10" fill="#91bcc6">
                                  <animate attributeName="r" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="0;0;10;10;10" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.25s"></animate>
                                  <animate attributeName="cx" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="16;16;16;50;84" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.25s"></animate>
                                </circle>
                                <circle cx="84" cy="50" r="10" fill="#07abcc">
                                  <animate attributeName="r" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="0;0;10;10;10" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.5s"></animate>
                                  <animate attributeName="cx" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="16;16;16;50;84" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.5s"></animate>
                                </circle>
                                <circle cx="16" cy="50" r="10" fill="#0a69aa">
                                  <animate attributeName="r" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="0;0;10;10;10" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.75s"></animate>
                                  <animate attributeName="cx" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="16;16;16;50;84" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.75s"></animate>
                                </circle>
                              </svg>
                            </div>
                          </div>
                          <!-- FETCH SPINNER CLOSE -->
                          <!-- fetch new end -->
                        <!-- </div> -->
                        <!-- fetch end -->
                      <!-- </div> -->
                      <button class="ml-2 btn btn-falcon-default btn-sm me-2" id="refresh_btn_id3">Refresh</button>
                      <div id="exporter"></div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 d-flex flex-row p-0">
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xm-6 d-flex justify-content-end pe-2">
                        <!-- <div class=""> -->
                          <select class="form-select form-select-sm" name="filterRecs" id="filterRecs" style="padding-right:2px; background-position: top 8px right 4px">
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="1000000000">All</option>
                          </select>
                        <!-- </div> -->
                      </div>
                      <div class="col-lg-8 col-md-8 col-xs-6 col-sm-6 justify-content-end">
                        <!-- search start -->
                        <div class="input-group input-group-sm">
                          <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                          <input id="search" type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                        </div>
                        <!-- search end -->
                      </div>
                    </div>
                  </div>
                </div>
              <table id="product_master" class="table table-striped table-hover dt-responsive display compact font-sans-serif fs--1" style="width: 100% !important">
                <thead>
                  <tr>
                    <th>Product&nbsp;Code</th>
                    <th>Description</th>
                    <th>Barcode</th>
                    <th>Group</th>
                    <th>Sort&nbsp;Code</th>
                    <th>Active</th>
                    <th>UOM</th>
                    <th>OBS</th>
                    <th>ALPA</th>
                    <th>Wholesale</th>
                    <th>CEQ</th>
                    <th>Staff</th>
                  </tr>
                </thead>
              </table>


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
    $('#spinner-class').hide();

    $('#product_master').DataTable({
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
        // {
        //   text: 'Refresh',
        //   className: 'btn btn-falcon-default btn-sm refresh_btn_id',
        //   attr: {
        //     id: 'refresh_btn_id'
        //   }
        // action: function ( e, dt, node, config ) {
        //     alert( 'Button activated' );
        // }
        // }


      ],
      'lengthMenu': [
        [10, 25, 50, 100, 100000000000],
        [10, 25, 50, 100, 'All']
      ],
      'ajax': {
        'url': 'datatable.php'
      },
      'order': [
        [0, 'desc']
      ],
      'columnDefs': [{
          "targets": [1, 2, 3, 4],
          "className": "text-nowrap"
        },
        {
          "targets": [5, 6],
          "className": "text-center"
        },
        {
          "targets": [7, 8, 9, 10, 11],
          "className": "dt-right"
        },
      ],
      'columns': [{
          data: 'ProductCode'
        },
        {
          data: 'ProductDescription'
        },
        {
          data: 'Barcode'
        },
        {
          data: 'Group'
        },
        {
          data: 'SortDesc'
        },
        {
          data: 'Active'
        },
        {
          data: 'UOM'
        },
        {
          data: 'OBS'
        },
        {
          data: 'ALPA'
        },
        {
          data: 'Wholesale'
        },
        {
          data: 'CEQ'
        },
        {
          data: 'Staff'
        }
      ],
      'responsive': 'true',
      'responsive': {
        details: {
          type: 'none'
        }
      },
      'language': {
        'info': '_START_ to _END_ of _TOTAL_ products',
        'infoEmpty': 'Showing 0 to 0 of 0 scans',
        'infoFiltered': '(filtered from _MAX_ total products)',
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

      }
    });

    inprogressTable = $("#product_master").DataTable();
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

    $('#refresh_btn_id3').on('click', function(re) {
      re.preventDefault();
      $('#product_master').DataTable().ajax.reload();
    });

    $('#refresh_btn_id2').on('click', function() {
    $('#spinner-class').show();
    $.ajax({
      type: "POST",
      url: "../../INB_OUT/API/GRWILLS/_fetch_products.php",
      success: function(msgx) {
        if (msgx === 'ProductsLoaded') {
          $('#spinner-class').hide();
          $('#product_master').DataTable().ajax.reload();
        } else {
          $('#spinner-class').hide();
        }
      }
    })
  });
  });
</script>