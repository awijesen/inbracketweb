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

        <div class="card mb-3">
          <!--/.bg-holder-->
          <div class="card-header bg-light">
            <div class="row justify-content-between align-items-center">
              <div class="col-10">
                <div class="row">
                  <div class="col-3">
                    <h5 class="card-header-title mb-0 col-12">OBS Fetch Orders</h5>
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
                <div class="d-flex justify-content-end col-md-5">
                  <div class="d-flex col-5 justify-content-end px-3" id="exporter"></div>
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
            <table id="fetch_order_tab" class="table table-striped table-hover dt-responsive display compact font-sans-serif fs--1" style="width: 100% !important">
              <thead>
                <tr>
                  <th>Fetch&nbsp;ID&nbsp;</th>
                  <th>Stockplate&nbsp;</th>
                  <th>Customer&nbsp;Name&nbsp;</th>
                  <th>Received&nbsp;Date&nbsp;</th>
                  <th>Received&nbsp;Qty&nbsp;</th>
                  <th>Dispatch&nbsp;Status&nbsp;</th>
                  <th>Ship&nbsp;Day&nbsp;</th>
                  <th>Delivery&nbsp;Instructions&nbsp;</th>
                  <th>Assigned&nbsp;Status&nbsp;</th>
                  <th>SO Status&nbsp;</th>
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

    <div class="modal fade" id="assignToOrder" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="assignToOrderLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
          <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" id="modalclose" aria-label="Close"></button></div>
          <div class="modal-body p-0">
            <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
              <h4 class="mb-1" id="assignToOrderLabel">Alert</h4>
              <!-- <p class="fs--2 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
            </div>
            <div class="p-4">
              <div class="row">
                <div class="col-lg-12">
                  <!-- <div class="d-flex"> -->
                  <div class="flex-1">
                    <h5 class="mb-2 fs-0" id="ord_msg">Are you sure you want to merge fetch order with a sales order?</h5>
                    <input type="button" class="btn btn-primary btn-sm" value="Yes" id="yes_click" name="yes_click" />
                    <input type="button" class="btn btn-secondary btn-sm" value="No" id="no_click" name="no_click" />
                    <div class="errMsg11" style="font-size: 13px; color:orange; margin-top: 6px;"></div>
                    <div id="listContainer">
                    <label for="_solist" class="mt-3">Select a sales order</label>
                    <select name="_solist" id="_solist" class="form-select form-select-sm" style="max-width: 200px">
                    </select>
                    </div>

                    <input type="hidden" id="id_">
                    <input type="hidden" id="recqty_">
                    <input type="hidden" id="sonum_">
                    <input type="hidden" id="so_">
                    <input type="hidden" id="customer_">
                    <input type="hidden" id="reference_">
                    <input type="hidden" id="uom_">
                    <input type="hidden" id="picker_">
                    <input type="hidden" id="shipday_">
                    <input type="hidden" id="assignedorder_">
                  </div>
                  <!-- </div> -->
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="confirmAdd">Confirm</button>
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

    $('#fetch_order_tab').DataTable({
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
        [10, 25, 50, 100, 100000000000],
        [10, 25, 50, 100, 'All']
      ],
      'ajax': {
        'url': 'datatable.php'
      },
      'order': [
        [3, 'desc']
      ],
      'columnDefs': [{
        "targets": [4, 5, 8],
        "className": "text-center"
      }],
      'columns': [{
          data: 'FetchID'
        },
        {
          data: 'StockPlate'
        },
        {
          data: 'CustomerName'
        },
        {
          data: 'DateReceived'
        },
        {
          data: 'ReceivedQty'
        },
        {
          data: 'DespatchedStatus'
        },
        {
          data: 'ShipDay'
        },
        {
          data: 'DeliveryInstructions'
        },
        {
          data: 'assigned_status'
        },
        {
          data: 'order_exists'
        },
        {
          data: 'ActionButton'
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

    inprogressTable = $("#fetch_order_tab").DataTable();
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
      $('#fetch_order_tab').DataTable().ajax.reload();
    })
  });

  $('#fetch_order_tab').on('click', '.assign_ft_order', function(rr) {
    rr.preventDefault();
    if ($(this).attr("so_status") == 'N') {
      $('#ord_msg').html('No assigned sales order found for the customer.');
      $('.modal-footer').hide();
      $('#assignToOrder').modal('show');
      $('#listContainer').hide();
      $('#yes_click').hide();
      $('#no_click').hide();
    } else {
      $('#ord_msg').html('Are you sure you want to merge fetch order with a sales order?');
      $('#id_').val($(this).attr("id"));
      $('#recqty_').val($(this).attr("qty"));
      $('#so_').val($(this).attr("order_num"));
      $('#sonum_').val($(this).attr("order_num"));
      $('#ord_num').html($(this).attr("order_num"));
      $('#customer_').val($(this).attr("cust"));
      $('#reference_').val($(this).attr("refer"));
      $('#uom_').val($(this).attr("uom"));
      $('#picker_').val($(this).attr("picker"));
      $('#shipday_').val($(this).attr("shipday"));
      $('#assignedorder_').val($(this).attr("assignedorder"));
      $('.modal-footer').hide();
      $('#listContainer').hide();
      $('#yes_click').show();
      $('#no_click').show();
      $.post('list.php', {
        customerName: $(this).attr("cust"),
        function(customerName) { // add return handler callback
          $('#assignToOrder').modal('show'); // show the modal
        }
      });
    }
    // $('#assignToOrder').modal('show');
  });

  $('#modalclose').on('click', function(ds) {
    ds.preventDefault();
    $('#ord_msg').html('');
    $('#ord_num').html('');
    $('#id_').val('');
    $('#recqty_').val('');
    $('#sonum_').val('');
    $('#customer_').val('');
    $('#reference_').val('');
    $('#picker_').val('');
    $('#uom_').val('');
    $('#shipday_').val('');
    $('#assignedorder_').val('');
    $('#so_').val('');

    $('#assignToOrder').modal('hide');
  });

  $('#confirmAdd').on('click', function(cl) {
    cl.preventDefault();

    var assignedorderexists = $('#assignedorder_').val();
    var order = $('#_solist option:selected').val();
    var quantity = $('#recqty_').val();
    var customer = $('#customer_').val();
    var reference = $('#reference_').val();
    var uom = $('#uom_').val();
    var picker = $('#picker_').val();
    var shipday = $('#shipday_').val();
    var id = $('#id_').val();
    var assignedon = '<?= $actualtime ?>';

    $.ajax({
      type: "POST",
      url: "_addfetchorder.php",
      data: {
        assignedorderexists: assignedorderexists,
        id: id,
        order: order,
        quantity: quantity,
        customer: customer,
        reference: reference,
        uom: uom,
        assignedon: assignedon,
        picker: picker,
        shipday: shipday
      },
      success: function(msgx) {
        if (msgx === 'success-') {
          $('#assignToOrder').modal('toggle');
          $('#fetch_order_tab').DataTable().ajax.reload();
        } else {
          $('#assignToOrder').modal('toggle');
        }
        //  alert(msgx);
      }
    })

  });

  $('#yes_click').on('click', function(clx) {
    clx.preventDefault();
    $('.modal-footer').show();
    $('#listContainer').show();
    var customer = $('#customer_').val();

    $.ajax({
      type: "POST",
      url: "formlist.php",
      data: {
        customer: customer
      },
      success: function(msgx) {
        $('#_solist').empty().append(msgx);
      }
    })

  });

  $('#no_click').on('click', function(xc) {
    xc.preventDefault();
    $('#assignToOrder').modal('hide');
  })
  $('#assignToOrder').on('hidden.bs.modal', function() {
    $('#_solist').empty();
    $('#ord_msg').html('');
    $('#ord_num').html('');
    $('#id_').val('');
    $('#recqty_').val('');
    $('#sonum_').val('');
    $('#customer_').val('');
    $('#reference_').val('');
    $('#picker_').val('');
    $('#uom_').val('');
    $('#shipday_').val('');
    $('#assignedorder_').val('');
    $('#so_').val('');
  });
</script>