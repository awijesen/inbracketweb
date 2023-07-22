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
<style>
  @media print {
  body * {
    visibility: hidden;
    
  }
  #plu_data, #plu_data * {
    visibility: visible;
  }
  #plu_data {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>
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
                    <h5 class="card-header-title mb-0 col-12">Non Putaway Report</h5>
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
            <table id="invoice_details_tab" class="table table-striped table-hover dt-responsive display compact font-sans-serif fs--1" style="width: 100% !important">
              <thead>
                <tr>
                  <th>Stock&nbsp;Plate</th>
                  <th>Receiver</th>
                  <th>PO&nbsp;Number</th>
                  <th>Product&nbsp;Code</th>
                  <th>Description</th>
                  <th>Recived&nbsp;Qty</th>
                  <th>Putaway&nbsp;Qty</th>
                  <th>Received&nbsp;On</th>
                  <th>Putaway&nbsp;Status</th>
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

    <div class="modal fade" id="replateLine" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="replateLineLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
          <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" id="modalclose" aria-label="Close"></button></div>
          <div class="modal-body p-0">
            <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
              <h4 class="mb-1" id="replateLineLabel">Stock Plate Detail</h4>
              <!-- <p class="fs--2 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
            </div>
            <div class="p-4">
              <div class="row">
                <div class="col-lg-12">
                  <!-- <div class="d-flex"> -->
                  <div class="flex-1">
                    <p class="mb-2 fs-0" id="plu_data" style="font-family: 'Code39'; font-size: 30px !important"></p>
                    <p class="mb-2 fs-0" id="plu_"></p>
                    <div class="errMsg11" style="font-size: 13px; color:orange; margin-top: 6px;"></div>
                  </div>
                  <!-- </div> -->
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="print_doc" onclick="window.print()">Print</button>
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

    $('#invoice_details_tab').DataTable({
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
        [7, 'desc']
      ],
      'columnDefs': [{
        "targets": [5, 6, 8],
        "className": "text-center"
      }],
      'columns': [{
          data: 'PlateNumber'
        },
        {
          data: 'Receiver'
        },
        {
          data: 'PONumber'
        },
        {
          data: 'ProductCode'
        },
        {
          data: 'ProductDescription'
        },
        {
          data: 'ReceivedQuantity'
        },
        {
          data: 'PutawayQuantity'
        },
        {
          data: 'ReceivedTimeStamp'
        },
        {
          data: 'pastatus'
        }
      ],
      'responsive': 'true',
      'responsive': {
        details: {
          type: 'none'
        }
      },
      'language': {
        'info': '_START_ to _END_ of _TOTAL_ lines',
        'infoEmpty': '',
        'zeroRecords': 'All caught up!',
        'infoFiltered': '(filtered from _MAX_ total lines)',
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

    inprogressTable = $("#invoice_details_tab").DataTable();
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
      $('#invoice_details_tab').DataTable().ajax.reload();
    })
  });

  $('#invoice_details_tab').on('click', '.plate_detail', function(cd) {
      cd.preventDefault();
      $('#plu_data').html("*" + $(this).attr("id") + "*");
      // $('#plu_').html($(this).attr("id"));
      $('#replateLine').modal('show');
    })


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

    $('#replateLine').modal('hide');
  });

  $('#confirmAdd').on('click', function(cl) {
    cl.preventDefault();

    var order = $('#so_').val();
    var quantity = $('#recqty_').val();
    var customer = $('#customer_').val();
    var reference = $('#reference_').val();
    var uom = $('#uom_').val();
    var picker = $('#picker_').val();
    var shipday = $('#shipday_').val();
    var assignedon = '<?= $actualtime ?>';

    $.ajax({
      type: "POST",
      url: "_addfetchorder.php",
      data: {
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
        alert(msgx);
      }
    })
  })
</script>