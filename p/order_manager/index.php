<?php

ini_set('session.cookie_domain', '.inbracket.com');
session_start();

if (!isset($_SESSION['LOGGED'])) {
  header('Location: ../../');
}
if (isset($_SESSION["STKM"]) && $_SESSION["STKM"] == 'On') {
  header('Location: ../../s/');
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
              <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="row">
                  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <h5 class="card-header-title mb-0 col-12">Assign Sales Orders</h5>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ps-0 ps-sm-3">
                <div class="row">
                  <div class="col-12 d-flex flex-row">
                    <p class="fs--1 ps-3" style="color: var(--falcon-blue); font-family: var(--falcon-font-sans-serif);" href="#">Total&nbsp;Order&nbsp;Value&nbsp;:&nbsp;</p>
                    <p class="fs--1" style="color: var(--falcon-blue); font-family: var(--falcon-font-sans-serif)" id="totalOrderVal"></p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- ///strnatcasecmp -->
          <!-- <div class="row col-lg-12">
                  <div class="col-lg-2 col-md-2 col-sm-10 col-xs-10 pe-0">
                    
                  <div class="row col-md-9 d-flex justify-content-end">
                    <div class="col-md-2 row">
                      
                    </div>
                    
                  </div>
                </div>

                -->
          <!-- ///// end -->
          <div class="card-body position-relative">
            <form action="" method="POST" name="_as_fm" id="_as_fm">
              <div class="container-fluid">
                <!-- assign order close- -->

                <div class="row">
                  <div class="col-lg-3 col-md-4 d-flex flex-row">
                    <!-- <div class="col-md-12 col-sm-12 col-xs-12 d-flex flex-row"> -->
                    <input type="hidden" id="reason_hidden" name="reason_hidden" style="height: 60px !important;">
                    <select name="_upkr" id="_upkr" class="form-select form-select-sm">
                      <option value="selectpicker">Select Picker</option>
                      <option value="DEL">Delete Order</option>
                      <option value="HOLD">Hold Order</option>
                      <?php
                      require(__DIR__ . '../../../dbconnect/db.php');

                      $sql = "SELECT * FROM INB_USERMASTER WHERE ActiveStatus='1' ORDER BY fname ASC";

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
                    <button id="_assign_ord" type="button" class="btn btn-falcon-primary btn-sm ms-2">Assign</button>
                    <!-- </div> -->
                  </div>
                  <div class="row col-lg-9 col-md-8 d-flex justify-content-end">
                    <div class="col-md-6 col-sm-12 col-xs-12 d-flex justify-content-end">
                      <!-- <div class="col-md-4"> -->
                      <!-- fetch start -->
                      <!-- <div class="col-md-4 d-flex flex-row"> -->
                      <!-- fetch new start -->
                      <button class="ml-2 btn btn-info btn-sm me-2" id="notes_btn">+&nbsp;Order&nbsp;notes</button>
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
                      <button class="ml-2 btn btn-falcon-default btn-sm me-2" id="refresh_btn_id2">Refresh</button>
                      <div id="mohanw"></div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 d-flex flex-row p-0">
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xm-6 d-flex justify-content-end pe-2">
                        <!-- <div class=""> -->
                        <select class="form-select form-select-sm" name="filterRecs" id="filterRecs" style="padding-right:2px; background-position: top 8px right 4px; width:100%">
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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="font-sans-serif fs--1 text-warning pt-1" id="_em">&nbsp</div>
                </div>
                <!-- new close -->


                <div class="row">
                  <table id="jquery-datatable-ajax-php" class="table table-striped table-hover dt-responsive display compact font-sans-serif fs--1 custFontSize" style="width: 100% !important">
                    <thead>
                      <tr>
                        <th>...</th>
                        <th>Sales&nbsp;Order</th>
                        <th>Picker</th>
                        <th>Holds</th>
                        <th><i class="fas fa-circle" style="font-size:8px; color: rgb(9, 87, 189)"></i></th>
                        <th>Customer</th>
                        <th>Reference</th>
                        <th>Value</th>
                        <th>Ship&nbsp;Day</th>
                        <th>Processsed&nbsp;On</th>
                        <th>Created&nbsp;By</th>
                        <th>Order&nbsp;Notes</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </form>
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

  <!-- <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Launch static backdrop modal</button> -->
  <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
      <div class="modal-content border-0">
        <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" id="reasonmodalclose" aria-label="Close"></button></div>
        <div class="modal-body p-0">
          <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
            <h4 class="mb-1" id="staticBackdropLabel">Hold Order</h4>
            <!-- <p class="fs--2 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
          </div>
          <div class="p-4">
            <div class="row">
              <div class="col-lg-12">
                <!-- <div class="d-flex"> -->
                <div class="flex-1">
                  <h5 class="mb-2 fs-0">Hold reason :</h5>

                  <input type="text" class="form-control" name="reasoncode" id="reasoncode">
                  <div class="errMsg11" style="font-size: 13px; color:orange; margin-top: 6px;"></div>
                </div>
                <!-- </div> -->
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="cleanmereason">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="deleteOrder" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="deleteOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
      <div class="modal-content border-0">
        <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" id="deletemodalclose" aria-label="Close"></button></div>
        <div class="modal-body p-0">
          <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
            <h4 class="mb-1" id="deleteOrderLabel">Delete Order</h4>
            <!-- <p class="fs--2 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
          </div>
          <div class="p-4">
            <div class="row">
              <div class="col-lg-12">
                <!-- <div class="d-flex"> -->
                <div class="flex-1">
                  <h5 class="mb-2 fs-0">Area you sure you want to delete the order?</h5>
                  <h6 class="mb-2 fs--1">This action can not be undone.</h6>
                  <div class="errMsg11" style="font-size: 13px; color:orange; margin-top: 6px;"></div>
                </div>
                <!-- </div> -->
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="delete_order">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="orderNotes" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="orderNotesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
      <div class="modal-content border-0">
        <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" id="orderNotesclose" aria-label="Close"></button></div>
        <div class="modal-body p-0">
          <div class="bg-light rounded-top-lg py-3 ps-4 pe-6 modal-header">
            <h4 class="mb-1" id="orderNotesLabel">Order notes</h4>
            <!-- <p class="fs--2 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
          </div>
          <div class="p-4">
            <div class="row">
              <div class="col-lg-12">
                <!-- <div class="d-flex"> -->
                <div class="flex-1">
                  <h5 class="mb-2 fs-0">Note:</h5>
                  <input type="text" class="form-control" id="msgtxt">

                  <div class="errMsg112" style="font-size: 13px; color:var(--falcon-red); margin-top: 6px;"></div>
                </div>
                <!-- </div> -->
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="save_order">Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="staticHoldReason" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticHoldReasonLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
      <div class="modal-content border-0">
        <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" id="reasonmodalcloseMessage" aria-label="Close"></button></div>
        <div class="modal-body p-0">
          <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
            <h4 class="mb-1" id="staticHoldReasonLabel">Order held reason</h4>
            <!-- <p class="fs--2 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
          </div>
          <div class="p-4">
            <div class="row">
              <div class="col-lg-12">
                <!-- <div class="d-flex"> -->
                <div class="flex-1">
                  <input type="hidden" id="so_">
                  <h3 class="mb-2 fs-0 reasonmessage" style="color: var(--falcon-gray)"></h3>
                </div>
                <!-- </div> -->
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="releaseorder_">Release Hold</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="notesPopup" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="notesPopupLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
      <div class="modal-content border-0">
        <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" id="notesPopupclose" aria-label="Close"></button></div>
        <div class="modal-body p-0">
          <div class="bg-light rounded-top-lg py-3 ps-4 pe-6 modal-header">
            <h4 class="mb-1" id="notesPopupLabel">Order Notes</h4>
            <!-- <p class="fs--2 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
          </div>
          <div class="p-4">
            <div class="row">
              <div class="col-lg-12">
                <!-- <div class="d-flex"> -->
                <div class="flex-1">
                  <input type="hidden" id="so__">
                  <h3 class="mb-2 fs-0 readnotes" style="color: var(--falcon-gray)"></h3>
                </div>
                <!-- </div> -->
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="closePopup">Delete</button>
            <button id="confDel" type="button" class="btn btn-danger">Confirm Delete?</button>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>

<script>
  $(document).ready(function() {
    $('#spinner-class').hide();
    $('#confDel').hide();

    $('#jquery-datatable-ajax-php').DataTable({
      // 'fixedHeader': true,
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
          className: 'btn btn-falcon-default btn-sm me-1',
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
        //   className: 'btn-primary btn-sm refresh_btn_id',
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
        [9, 'desc']
      ],
      'columns': [{
          data: 'selector'
        },
        {
          data: 'SalesOrderNumber'
        },
        {
          data: 'Picker'
        },
        {
          data: 'OnHoldReason'
        },
        {
          data: 'orderType'
        },
        // {
        //   data: 'OrderNotes'
        // },
        {
          data: 'OrderCustomer'
        },
        {
          data: 'Reference'
        },
        {
          data: 'OrderValue'
        },
        {
          data: 'ShipDay'
        },
        {
          data: 'ProcessedDate'
        },
        {
          data: 'CreatedBy'
        },
        {
          data: 'OrderNotes'
        }
      ],
      'columnDefs': [{
          orderable: false,
          targets: [0]
        },
        {
          "targets": [3, 11],
          "className": "text-center"
        },
        {
          "targets": [5, 6, 7, 8, 9],
          "className": "text-nowrap"
        }
      ],
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
        total_order_value = api.column(7, {
          page: 'current'
        }).data().reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

        total_order_value = parseFloat(total_order_value);
        // total_salary = parseFloat(total_salary);
        // Update footer
        $('#totalOrderVal').html("$" + total_order_value.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));

      }
    });

    codeListTable = $("#jquery-datatable-ajax-php").DataTable();
    // new $.fn.dataTable.Buttons(codeListTable, {

    //    'buttons': [{
    //       extend: 'collection',
    //       className: 'btn btn-primary btn-sm',
    //       text: 'Export',
    //       buttons: [
    //         'copy',
    //         'excel',
    //         'csv',
    //         'pdf',
    //         'print'
    //       ]
    //     }]
    // })

    codeListTable.buttons().container().appendTo('#mohanw');

    $(".buttons-collection").removeClass("btn-secondary");
  });

  $('#_assign_ord').on('click', function(ef) {
    ef.preventDefault();
    var fd = $('#_as_fm').serialize();
    var gb = $('#_upkr').val();
    var gg = $('#reason_hidden').val();
    var gg = $('#reason_hidden').val();
    // alert(gb);
    // alert(gg);

    $.ajax({
      type: "POST",
      data: $('#_as_fm').serialize(),
      // data: {action: gb, notes: gg},
      url: "itry_.php",
      success: function(msgx) {
        $resp = msgx.substring(0, 12);
        if ($resp == 'success-dsds') {
          $('#_em').html(msgx);
          $('#_upkr').prop('selectedIndex', 0);
          $('#jquery-datatable-ajax-php').DataTable().ajax.reload();
        } else if (msgx.substring(0, 3) == 'Sel') {
          $('#_em').html(msgx);
        } else if (msgx.substring(0, 3) == 'Ord') {
          $('#_em').html(msgx);
        } else {
          $('#_em').html(msgx);
          $('#_upkr').prop('selectedIndex', 0);
          $('#reason_hidden').val('');
          $('#jquery-datatable-ajax-php').DataTable().ajax.reload();
        }
      }
    })
  });


  $('#delete_order').on('click', function(ecf) {
    ecf.preventDefault();
    var fd = $('#_as_fm').serialize();
    var gb = $('#_upkr').val();
    var gg = $('#reason_hidden').val();
    var gg = $('#reason_hidden').val();
    // alert(gb);
    // alert(gg);

    $.ajax({
      type: "POST",
      data: $('#_as_fm').serialize(),
      // data: {action: gb, notes: gg},
      url: "_d.php",
      success: function(msgxc) {
        $('#deleteOrder').modal('hide');
        $('#_em').html('');
        $('#_upkr').prop('selectedIndex', 0);
        $('#jquery-datatable-ajax-php').DataTable().ajax.reload();
      }
    })
  });



  //  var table = $('#jquery-datatable-ajax-php').DataTable();

  // #myInput is a <input type="text"> element
  $('#search').on('keyup', function() {
    codeListTable.search(this.value).draw();
    codeListTable.state.save();
  });

  $('#filterRecs').on('change', function(ef) {
    ef.preventDefault();
    var optVal = $('#filterRecs').val();
    codeListTable.page.len(optVal).draw();
    // alert(optVal);
  })

  $('#refresh_btn_id2').on('click', function() {
    $('#spinner-class').show();
    $.ajax({
      type: "POST",
      url: "../../INB_OUT/API/GRWILLS/_fetch_order_lines.php",
      success: function(msgx) {
        if (msgx === 'Loaded') {
          $('#spinner-class').hide();
          $('#jquery-datatable-ajax-php').DataTable().ajax.reload();
        } else {
          $('#spinner-class').hide();
        }
      }
    })
  });

  $('#staticBackdrop').on('shown.bs.modal', function(bsmx) {
    bsmx.preventDefault();
    $('#reasoncode').val('');
    $('.errMsg11').html('');
    $('#reason_hidden').val('');
  });

  $('#reasonmodalclose').on('click', function(aw) {
    aw.preventDefault();
    $('#reasoncode').val('');
    $('#staticBackdrop').modal('hide');
    $('#reason_hidden').val('');
    $("#_upkr").val("selectpicker");
    $('.errMsg11').html('');
  });

  $('#notesPopupclose').on('click', function(aw) {
    aw.preventDefault();
    $('#readnotes').val('');
    $('#notesPopup').modal('hide');
    $('#confDel').hide();
  });

  $('#deletemodalclose').on('click', function(awc) {
    awc.preventDefault();
    // $('#reasoncode').val('');
    $('#deleteOrder').modal('hide');
    // $('#reason_hidden').val('');
    $("#_upkr").val("selectpicker");
    // $('.errMsg11').html('');
  });

  $('#cleanmereason').on('click', function(gcz) {
    gcz.preventDefault();
    var shenu = '<?php echo "-" . $_SESSION['UCODE'] . ", " . date("D M d, Y G:i") ?>';
    if ($('#reasoncode').val().length >= 2) {
      $('#reason_hidden').val($('#reasoncode').val() + shenu);
      $('#staticBackdrop').modal('hide');
    } else {
      $('.errMsg11').html('Reason required.');
    }

  })

  $('#jquery-datatable-ajax-php').on('click', '#reason-view', function(cv) {
    cv.preventDefault();
    $('.reasonmessage').html($(this).attr('rmessage'));
    $('#so_').val($(this).attr("orderref"));
    $('#staticHoldReason').modal('show');
  });

  $('#jquery-datatable-ajax-php').on('click', '#notes-view', function(cv) {
    cv.preventDefault();
    $('.readnotes').html($(this).attr('rdmessage'));
    $('#so__').val($(this).attr("orderreff"));
    $('#confDel').hide();
    $('#closePopup').show();
    $('#notesPopup').modal('show');
    $('#_em').html('');
  });

  $('#reasonmodalcloseMessage').on('click', function(aw) {
    aw.preventDefault();
    // $('#reasoncode').val('');
    $('#staticHoldReason').modal('hide');
    // $('#reason_hidden').val('');
    // $("#_upkr").val("selectpicker");
    // $('.errMsg11').html('');
  })

  $('#orderNotesclose').on('click', function(awx) {
    awx.preventDefault();
    $('#msgtxt').val('');
    $('#orderNotes').modal('hide');
    $('#confDel').hide();
    $('#_em').html('');
  })

  $('#_upkr').on('change', function(ef) {
    ef.preventDefault();
    var selectedVal = $('#_upkr').val();

    if (selectedVal == 'HOLD') {
      $('#staticBackdrop').modal('show');
      $('.errMsg11').html('');
    } else if (selectedVal == 'DEL') {

      $.ajax({
        type: "POST",
        url: "_verify_del.php",
        data: $('#_as_fm').serialize(),
        success: function(msgs) {
          if (msgs === 'selectorder') {
            $('#_em').html('No order(s) selected');
            $("#_upkr").val("selectpicker");
          } else if (msgs === 'available') {
            $('#deleteOrder').modal('show');
            $('#_em').html('');
          }
        }
      })


      // $('.errMsg11').html('');
    }
  })

  $('#refresh_btn_id').on('click', function(re) {
    re.preventDefault();
    $('#jquery-datatable-ajax-php').DataTable().ajax.reload();
  });

  $('#releaseorder_').on('click', function(df) {
    df.preventDefault();

    var toDel = $('#so_').val();

    $.ajax({
      type: "POST",
      url: "_clear.php",
      data: {
        sotodel: toDel
      },
      success: function(msgx) {
        if (msgx === 'deleted') {
          $('#staticHoldReason').modal('hide');
          $('#jquery-datatable-ajax-php').DataTable().ajax.reload();
        } else {
          $('#staticHoldReason').modal('hide');
          alert('delete error');
          $('#jquery-datatable-ajax-php').DataTable().ajax.reload();
        }
      }
    })
  });

  $('#notes_btn').on('click', function(cr) {
    cr.preventDefault();

    $.ajax({
      type: "POST",
      data: $('#_as_fm').serialize(),
      url: "addnotes.php",
      success: function(mx) {
        if (mx === 'No orders selected') {
          $('#_em').html('No order(s) selected');
        } else {
          $('#_em').html('');
          $('#orderNotes').modal('show');
        }
        // $('#jquery-datatable-ajax-php').DataTable().ajax.reload();

      }
    })

  })

  $('#save_order').on('click', function(uu) {
    uu.preventDefault();

    var t = $('#msgtxt').val();
    var shenu = '<?php echo "-" . $_SESSION['UCODE'] . ", " . date("D M d, Y G:i") ?>';

    if (t === '' || t.length < 2) {
      $('#errMsg112').html('Notes required');
    } else {
      $('#errMsg112').html('Notes required');

      $.ajax({
        type: "POST",
        data: $('#_as_fm').serialize() + '&tVal=' + t + shenu,
        url: "addnotes.php",
        success: function(mx) {
          if (mx === 'No orders selected') {
            $('#_em').html('No order(s) selected');
          } else {
            $('#_em').html('');
            $('#orderNotes').modal('hide');
            $('#jquery-datatable-ajax-php').DataTable().ajax.reload();
          }
        }
      })
    }
  });

  $('#closePopup').on('click', function(vf) {
    vf.preventDefault();
    $('#confDel').show();
    $('#closePopup').hide();
  });

  $('#confDel').on('click', function(po) {
    po.preventDefault();
    var sonum = $('#so__').val();
    $.ajax({
      type: "POST",
      data: {so:sonum},
      url: "_clearnotes.php",
      success: function(mxc) {
        if (mxc === 'updated') {
          $('#notesPopup').modal('hide');
          $('#jquery-datatable-ajax-php').DataTable().ajax.reload();
        } else {
          alert('Error deleting note. Please try again.');
        }
      }
    })
  });

  $(".modal-header").on("mousedown", function(mousedownEvt) {
    var $draggable = $(this);
    var x = mousedownEvt.pageX - $draggable.offset().left,
        y = mousedownEvt.pageY - $draggable.offset().top;
    $("body").on("mousemove.draggable", function(mousemoveEvt) {
        $draggable.closest(".modal-content").offset({
            "left": mousemoveEvt.pageX - x,
            "top": mousemoveEvt.pageY - y
        });
    });
    $("body").one("mouseup", function() {
        $("body").off("mousemove.draggable");
    });
    $draggable.closest(".modal").one("bs.modal.hide", function() {
        $("body").off("mousemove.draggable");
    });
});

</script>