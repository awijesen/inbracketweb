<?php

session_start();
if (!isset($_SESSION['LOGGED'])) {
  header('Location: ../../');
}

$PorderToFetch = htmlspecialchars($_GET['link']);

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
                      <a href="../scheduled_po_history/" class="btn btn-primary btn-sm" style="background-color: var(--falcon-blue)">Back</a>
                    </div>
                    <div class="col-5">
                      <h5 class="card-header-title mb-0">Purchase Order Detail</h5>
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

              $sql = "SELECT distinct(VendorName), Reference, OrderValue
              FROM INB_PURCHASE_ORDERS 
              WHERE PONumber=? 
              group by PONumber";

              $stmt = $conn->prepare($sql);
              $stmt->bind_param("s", $PorderToFetch);
              $stmt->execute();
              $result = $stmt->get_result();
              while ($row = $result->fetch_assoc()) {
                echo "
                    <div class='col-lg-12' style='padding: 1.25rem'>
                      <div class='row'>
                      <div class='col-lg-2 col-sm-12'>
                      <label for='orderNumber' class='form-label'>Purchase Order Number</label>
                      <div class='col-12 fnt s13' id='orderNumber'>" . $PorderToFetch . "</div>
                      </div>
                      <div class='col-lg-2 col-sm-12'>
                      <label for='referenceOrd' class='form-label'>Reference</label>
                      <div class='col-12 fnt s13' id='referenceOrd'>".$row['Reference']."</div>
                      </div>
                      <div class='col-lg-2 col-sm-12'>
                      <label for='OrdVal' class='form-label'>Value</label>
                      <div class='col-12 fnt s13' id='OrdVal'>".$row['OrderValue']."</div>
                      </div>
                      <div class='col-lg-5 col-sm-12'>
                      <label for='storeName' class='form-label'>Vendor</label>
                      <div class='col-12 fnt s13' id='storeName'>" . $row['VendorName'] . "</div>
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

              <div class="col-lg-12" style="padding: 1.25rem">
                <!-- table here -->
                <table id="purchaseorder_detail" class="table table-stripe table-hover dt-responsive display compact fs--2" style="width: 100% !important">
                  <thead style="font-family: 'Poppins'; font-size: 13px">
                    <th>Product&nbsp;Code</th>
                    <th>Description</th>
                    <th>Order&nbsp;Qty</th>
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
    $('#purchaseorder_detail').DataTable({
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
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, 'All']
      ],
      'stateSave': 'true',
      'autoWidth': 'true',
      'responsive': 'true',
      "lengthChange": true,
      "fnCreatedRow": function(nRow, aData, iDataIndex) {
        $(nRow).attr('id', aData[0]);
      },
      "serverSide": true,
      'processing': 'true',
      'paging': 'true',
      'length': 10,
      'order': [],
      'destroy': 'true',
      'ajax': {
        'url': './mfetch_po.php',
        'type': 'post',
        'data': {
          'links': '<?= $PorderToFetch ?>'
        }
      },
      "columnDefs": [{
        'targets': [0, 1],
        'orderable': false
      }],
      "language": {
        "info": "_PAGE_ of _PAGES_ pages",
        "infoFiltered": ""
      }
    });


    pordersTabledata = $("#purchaseorder_detail").DataTable();

    pordersTabledata = $("#purchaseorder_detail").DataTable();
    new $.fn.dataTable.Buttons(pordersTabledata, {
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

    pordersTabledata.buttons().container().appendTo('#exporter');

    $('#search').on('keyup', function() {
      pordersTabledata.search(this.value).draw();
      pordersTabledata.state.save();
    });

    pordersTabledata.buttons().container().appendTo('#exporter');
    $('#filterRecs_InProgress').on('change', function(ef) {
      ef.preventDefault();
      var optVal = $('#filterRecs_InProgress').val();
      pordersTabledata.page.len(optVal).draw();
      // alert(optVal);
    })

  });
</script>