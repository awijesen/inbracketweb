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
                  <div class="col-3">
                    <h5 class="card-header-title mb-0 col-12">Picks In Progress</h5>
                  </div>
                </div>
              </div>
              <!-- <div class="col-2 ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as read</a></div> -->
            </div>
          </div>
          <div class="card-body position-relative">
            <!-- Body -->
            <div class="row">
              <div class="row col-md-12 d-flex justify-content-end">
                <div class="d-flex justify-content-end col-md-9">
                  <div class="d-flex col-4 justify-content-end px-3" id="exporter"></div>
                  <div class="col-2">
                    <select class="form-select form-select-sm" name="filterRecs_InProgress" id="filterRecs_InProgress" style="padding-right:2px; background-position: top 8px right 4px">
                      <option value="20">20</option>
                      <option value="30">30</option>
                      <option value="50">50</option>
                      <option value="100">100</option>
                      <option value="1000000000">All</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="input-group input-group-sm">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                    <input id="search" type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                  </div>
                </div>
              </div>
            </div>
            <table id="picked-in-progress" class="table table-striped table-hover dt-responsive display compact font-sans-serif custFontSize" style="width: 100% !important">
              <thead>
                <tr>
                  <th>Sales&nbsp;Order</th>
                  <th>Picker</th>
                  <th>Customer</th>
                  <th>Reference</th>
                  <th>Ship&nbsp;Day</th>
                  <th>Flag</th>
                  <th>Assigned&nbsp;On</th>
                  <th>Total&nbsp;Lines</th>
                  <th>Picked&nbsp;Lines</th>
                  <th>%</th>
                  <th>. . .</th>
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

    <div class="modal fade" id="flagOrderModal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="flagOrderModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
          <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" id="reasonmodalcloseMessage" aria-label="Close"></button></div>
          <div class="modal-body p-0">
            <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
              <h4 class="mb-1" id="flagOrderModalLabel"></h4>
              <!-- <p class="fs--2 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
            </div>
            <div class="p-4">
              <div class="row">
                <div class="col-lg-12">
                  <!-- <div class="d-flex"> -->
                  <div class="flex-1">
                    <div style="font-family: var(--falcon-font-sans-serif)" id="message_box"></div>
                    <div style="font-family: var(--falcon-font-sans-serif)" id="dropcontainer" class="mb-2 mt-2">
                      <select class="form-select form-select-sm" name="assign_priority" id="assign_priority">
                        <option value="select_">Select</option>
                        <option value="P0">Urgent</option>
                        <option value="P1">Priority 1</option>
                        <option value="P2">Priority 2</option>
                        <option value="P3">Priority 3</option>
                        <option value="P4">Priority 4</option>
                        <option value="P5">Priority 5</option>
                        <option value="P6">Priority 6</option>
                      </select>
                    </div>
                    <input type="hidden" id="so__">
                    <input type="hidden" id="status">
                    <h3 class="mb-2 fs--1 reasonmessage" style="color: var(--falcon-red)"></h3>
                  </div>
                  <!-- </div> -->
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="markUrgent_">Yes</button>
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

    $('#picked-in-progress').DataTable({
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
        [10, 25, 50, 100, 100000000],
        [10, 25, 50, 100, 'All']
      ],
      'ajax': {
        'url': 'datatable.php'
      },
      'order': [
        [6, 'desc']
      ],
      'columnDefs': [{
          "targets": [2, 3, 4, 5],
          "className": "text-nowrap"
        },
        {
          "targets": [7, 8, 9, 10],
          "className": "text-center"
        }
      ],
      'columns': [{
          data: 'SalesOrderNumber'
        },
        {
          data: 'Picker'
        },
        {
          data: 'OrderCustomer'
        },
        {
          data: 'Reference'
        },
        {
          data: 'ShipDay'
        },
        {
          data: 'CustomFlag'
        },
        {
          data: 'AssignedOn'
        },
        {
          data: 'TotalLines'
        },
        {
          data: 'PickedLines'
        },
        {
          data: 'Percentage'
        },
        {
          data: 'markUrgent'
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

    inprogressTable = $("#picked-in-progress").DataTable();
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

    $('#refresh_btn_id').on('click', function(re) {
      re.preventDefault();
      $('#picked-in-progress').DataTable().ajax.reload();
    });

    $('#picked-in-progress').on('click', '.orderFlag_', function(cv) {
      cv.preventDefault();
      var ord = $(this).attr("id");
      var sta = $(this).attr("status");

      if (sta !== '') {
        $('#dropcontainer').hide();
        $('#assign_priority').prop('selectedIndex', 0);
        $('#flagOrderModalLabel').html('Remove Order Flag');
        $('#message_box').html('Do you want remove urgent flag from the sales order?');
      } else {
        $('#dropcontainer').show();
        $('#assign_priority').prop('selectedIndex', 0);
        $('#flagOrderModalLabel').html('Flag Order');
        $('#message_box').html('Do you want to mark the order as urgent?');
      }

      $('#so__').val($(this).attr("id"));
      $('#status').val($(this).attr("status"));
      $('#flagOrderModal').modal('show');
    });

    $('#reasonmodalcloseMessage').on('click', function(aw) {
      aw.preventDefault();
      $('#so__').val('');
      $('#status').val('');
      $('.reasonmessage').html('');
      $('#assign_priority').prop('selectedIndex', 0);
      $('#flagOrderModal').modal('hide');

    });

    $('#markUrgent_').on('click', function(cv) {
      cv.preventDefault();
      var stat = $('#status').val();
      var orderToMark = $('#so__').val();
      var urgency = $('#assign_priority option:selected').val();


      if (stat === '') {
        if (urgency === 'select_') {
          $('.reasonmessage').html('Please select priority level from the dropdown menu');
        } else {
          $('.reasonmessage').html('');

          $.ajax({
            type: "POST",
            url: "_mrk.php",
            data: {
              otom: orderToMark,
              urg: urgency
            },
            success: function(msgx) {
              if (msgx === 'mkd') {
                $('#flagOrderModal').modal('hide');
                $('#picked-in-progress').DataTable().ajax.reload();
              } else if (msgx === 'umkd') {
                $('.reasonmessage').html('Error! Please refresh the browser and try again');
                $('#picked-in-progress').DataTable().ajax.reload();
              }
            }
          });
        }
      } else {
        $.ajax({
          type: "POST",
          url: "_umrk.php",
          data: {
            otom: orderToMark
          },
          success: function(msgx) {
            if (msgx === 'rkd') {
              $('#flagOrderModal').modal('hide');
              $('#picked-in-progress').DataTable().ajax.reload();
            } else if (msgx === 'urkd') {
              $('.reasonmessage').html('Error! Please refresh the browser and try again');
              $('#picked-in-progress').DataTable().ajax.reload();
            }
          }
        });
      }
    })
  });
</script>