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
                    <h5 class="card-header-title mb-0 col-12">Orders to Invoice</h5>
                  </div>
                </div>
              </div>
              <!-- <div class="col-2 ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as read</a></div> -->
            </div>
          </div> 
          <div class="card-body position-relative">
            <!-- Body -->
            <div class="row">
              <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                <label for="searchByHasFlags">Has flags</label>
                <select class="form-select form-select-sm" name="searchByHasFlags" id="searchByHasFlags" aria-label=".form-select-sm example">
                  <option selected value="">All</option>
                  <option value="11">Yes</option>

                </select>
              </div>
              <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                <label for="searchBySO">SO&nbsp;Number</label>
                <input type="text" name="searchBySO" id="searchBySO" class="form-control form-control-sm">
              </div>
              <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                <label for="searchByCustomer">Customer</label>
                <input type="text" name="searchByCustomer" id="searchByCustomer" class="form-control form-control-sm">
              </div>
              <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                <label for="searchByRef">Reference</label>
                <input type="text" name="searchByRef" id="searchByRef" class="form-control form-control-sm">
              </div>
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <label for="searchByShipday">Ship day</label>
                <select class="form-select form-select-sm" name="searchByShipday" id="searchByShipday" aria-label=".form-select-sm example">
                  <option value="">Select</option>
                  <?php
                  require(__DIR__ . '../../../dbconnect/db.php');

                  $sql = "SELECT
                  ShipDay,
                  PushedStatus,
                  InvoiceState
                  FROM INB_COMPLETED_PICKS
                  WHERE PushedStatus = 'Pushed' AND ShipDay IS NOT NULL AND InvoiceState IS NULL
                  GROUP BY ShipDay;";

                  $stmt = $conn->prepare($sql);
                  // $stmt->bind_param("s", $search);
                  // $search = $findOrder;
                  $stmt->execute();
                  $result = $stmt->get_result();

                  if (mysqli_num_rows($result) > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo '<option value="' . $row['ShipDay'] . '">' . $row["ShipDay"] . '</option>';
                    }
                  } else {
                    echo "error";
                  }    ?>
                </select>
              </div>
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">

              <label for="datepicker-from">From *</label>
              <input type="text" data-date-format="yyyy-mm-dd" class="form-control form-control-sm datepicker" name="datepicker-from" id="datepicker-from">


              </div>
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
              <label for="datepicker-to">To *</label>
              <input type="text" data-date-format="yyyy-mm-dd" class="form-control form-control-sm datepicker-to" name="datepicker-to" id="datepicker-to">
                
              </div>
              <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                <label for="exporter">&nbsp;</label>
                  <div class="col-md-1 col-lg-1" id="exporter"></div>
                
              </div>
              <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
              <div class="col-md-12 col-lg-12">
                <label for="filterRecs_InProgress">Records</label>
                    <select class="form-select form-select-sm" name="filterRecs_InProgress" id="filterRecs_InProgress" style="padding-right:2px; background-position: top 8px right 4px">
                      <option value="20">20</option>
                      <option value="30">30</option>
                      <option value="50">50</option>
                      <option value="100">100</option>
                      <option value="500">500</option>
                      <option value="1000">1000</option>
                      <option value="1000000000">All</option>
                    </select>
                  </div>
                  </div>
            </div>

            <!-- close body -->
          </div>
        </div>
        <div class="card mb-3">

          <div class="card-body pt-0 pt-md-3">
            <table id='vehiclesTable' class="table table-striped table-hover dt-responsive display compact font-sans-serif fs--1" style="width: 100% !important">
              <thead>
                <tr>
                  <th>Sales&nbsp;Order</th>
                  <th>Print</th>
                  <th>Customer</th>
                  <th>Flags</th>
                  <th>Order&nbsp;Reference</th>
                  <th>Ship&nbsp;Day</th>
                  <th>Pick&nbsp;By</th>
                  <th>Picked&nbsp;On</th>
                  <th>Pushed&nbsp;Status</th>
                  <th>Pushed&nbsp;On *</th>
                  <th>Pushed&nbsp;By</th>
                  
                </tr>
              </thead>

            </table>
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
    
    var requestFromFilter = 1;
    var dataTable = $('#vehiclesTable').DataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'stateSave': true,
      'searching': false, // Remove default Search Control
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
      }],
      'lengthMenu': [
        [20, 50, 100, 500],
        [20, 50, 100, 500]
      ],
      'ajax': {
        'url': 'data.php',
        'data': function(data) {
          // Read values
          data.searchByHasFlags = $('#searchByHasFlags').val();
          data.searchByCustomer = $('#searchByCustomer').val();
          data.searchBySO = $('#searchBySO').val();
          data.searchByRef = $('#searchByRef').val();
          data.searchByShipday = $('#searchByShipday option:selected').val();
          data.searchByFrom = $('#datepicker-from').val();
          data.searchByTo = $('#datepicker-to').val();
        }
      },
      'columnDefs': [
        // {
        //   "targets": [5],
        //   "className": "text-center"
        // },
        // {
        //   "targets": [4, 5, 6, 7, 8, 9],
        //   "className": "text-end"
        // },
        {
          "targets": [2,4,5,6,7,8,9],
          "className": "text-nowrap"
        }
      ],
      'columns': [{
          data: 'SalesOrderNumber'
        },
        {
          data: 'PrintDocket'
        },
        {
          data: 'OrderCustomer'
        },
        {
          data: 'Notes'
        },
        {
          data: 'Reference'
        },
        {
          data: 'ShipDay'
        },
        {
          data: 'PickedBy'
        },
        {
          data: 'PickedOn'
        },
        {
          data: 'PickStatus'
        },
        {
          data: 'PushedTime'
        },
        {
          data: 'PushedBy'
        }
      ],
    });

    inprogressTable = $("#vehiclesTable").DataTable();
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
    $('select').change(function() {
      requestFromFilter = 1
      dataTable.draw();
    });

    $('#filterRecs_InProgress').on('change', function(ef) {
      ef.preventDefault();
      var optVal = $('#filterRecs_InProgress').val();
      inprogressTable.page.len(optVal).draw();
      // alert(optVal);
    });

    $('input[type="text"]').keyup(function() {
      requestFromFilter = 1
      dataTable.draw();
    });

    $('input[type="text"]').change(function() {
      requestFromFilter = 1
      dataTable.draw();
    });

    $("#resetForm").click(function() {
      $('select').each(function() {
        this.selectedIndex = 0;
      });
      $('input[type="text"]').each(function() {
        this.value = "";
      });
      requestFromFilter = 1
      dataTable.draw();
    });
  });

  $(function(){
  $('#datepicker-from').datepicker();
});
$(function(){
  $('#datepicker-to').datepicker();
});

</script>