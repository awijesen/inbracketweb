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
              <div class="col-8">
                <div class="row">
                  <div class="row">
                    <div class="col-1">
                    <!-- href="../invoice_ready_test/" -->
                      <a class="btn btn-primary btn-sm" id="closebtn_" style="background-color: var(--falcon-blue)">Close</a>
                    </div>
                    <div class="col-5">
                      <h5 class="card-header-title mt-1 ml-2">Order Line Details</h5>
                    </div>
                  </div>
                </div>
              </div>
        
              <div class="col-4 ps-0 ps-sm-3 d-flex flex-row justify-content-end" id="msg-box"><a class="card-link fw-normal" order-id="<?= $orderToFetch ?>" href="#" id="invoice_now">Mark as invoiced</a>
             <a class="card-link fw-normal" order-id="<?= $orderToFetch ?>" href="#" id="sebdback_now">Send back to Warehouse</a>           </div>
        
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
                      <div class='col-lg-5 col-sm-12'>
                      <label for='storeName' class='form-label'>Customer</label>
                      <div class='col-12 fnt s13' id='storeName'>" . $row['OrderCustomer'] . "</div>
                      </div>
                    </div>
                    </div>";
              }

              ?>

              <div class="col-lg-12" style="padding: 1.25rem">

                <div class="row">
                  <div class="row col-md-12 d-flex justify-content-end">
                    <div class="d-flex justify-content-end col-md-5">
                      <div class="d-flex col-4 justify-content-end px-3" id="exporter"></div>
                      <div class="col-4">
                        <select class="form-select form-select-sm" name="filterRecs_InProgress" id="filterRecs_InProgress" style="padding-right:2px; background-position: top 8px right 4px">
                          <option value="1000000000">All</option>  
                          <option value="20">20</option>
                          <option value="30">30</option>
                          <option value="50">50</option>
                          <option value="100">100</option>
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


                <table id="orderpick_details" class="table table-striped table-hover dt-responsive display compact font-sans-serif fs--1" style="width: 100% !important">
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
            </div>
            <!-- end -->
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

</body>

</html>

<script>
  $(document).ready(function() {
    $('#orderpick_details').DataTable({
      // 'dom': 'Blfrtip',
      // 'buttons': [
      //   'copyHtml5',
      //   'excelHtml5',
      //   'csvHtml5',
      //   'pdfHtml5'
      // ],
      'lengthMenu': [
        [-1, 10, 30, 50, 100],
        ['All', 10, 30, 50, 100]
      ],
      'stateSave': 'true',
      stateSaveParams: function(settings, data) {
        data.searchCountry = $('#search').val();
      },
      stateLoadParams: function(settings, data) {
        $('#search').val(data.searchCountry);
      },
      'dom': '<<B>t<ip>>',
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
          'targets': [0, 1],
          'orderable': false
        },
        {
          "targets": [2, 3], // your case first column
          "className": "text-center"
        }
      ],
      "language": {
        'info': '_START_ to _END_ of _TOTAL_ lines',
        'infoEmpty': 'Showing 0 to 0 of 0 lines',
        'infoFiltered': '',
      }
    });

    inprogressTabledata = $("#orderpick_details").DataTable();

    inprogressTabledata = $("#orderpick_details").DataTable();
    new $.fn.dataTable.Buttons(inprogressTabledata, {
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


    $('#invoice_now').on('click', function(dg) {
      dg.preventDefault();
    // $('#messenger_a').show();
    var clickId = $(this).attr('order-id');
    // $(this).prop('disabled', true);
    // alert(clickId);
    $.ajax({
      url: "_invoiced.php", //the page containing php script
      type: "POST", //request type,
      data: {
        link: clickId,
      },
      success: function(result) {
        $('#msg-box').html("<span class='badge' style='background-color: var(--falcon-red)'>" + result + "</span>");
        // location.reload();
        // $( "#dataRef" ).load( "index.php #dataRef" );
        // $('#contentContainer').load('pages/reports/report_pick_summary.php');
        // $('#messenger_a').hide();
      }
      // ,
      // error: function(err) {
      //   alert(err);
      //  // alert('Error : WZSD32');
      // }
    });
  });

  $('#sebdback_now').on('click', function(dgx) {
      dgx.preventDefault();
    // $('#messenger_a').show();
    var clickId = $(this).attr('order-id');

    $.ajax({
      url: "_send_back_wh.php", //the page containing php script
      type: "POST", //request type,
      data: {
        link: clickId,
      },
      success: function(result) {
        $('#msg-box').html("<span class='badge' style='background-color: var(--falcon-red)'>" + result + "</span>");
        // window.location.replace('../invoice_ready');
      }
  
    });
  });

  $('#closebtn_').on('click', function(xc) {
    xc.preventDefault();
    window.top.close();
  })
  });
</script>