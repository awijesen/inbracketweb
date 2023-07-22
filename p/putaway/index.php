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
                    <h5 class="card-header-title mb-0 col-12">Putaway History Report</h5>
                  </div>
                </div>
              </div>
              <!-- <div class="col-2 ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as read</a></div> -->
            </div>
          </div>
          <div class="card-body position-relative">
            <!-- Body -->
            <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <label for="searchByPO">PO&nbsp;Number</label>
                <input type="text" name="searchByPO" id="searchByPO" class="form-control form-control-sm">
              </div>
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <label for="searchByName">Product&nbsp;Code</label>
                <input type="text" name="searchByName" id="searchByName" class="form-control form-control-sm">
              </div>
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <label for="searchByName">Description</label>
                <input type="text" name="searchByDescription" id="searchByDescription" class="form-control form-control-sm">
              </div>
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <label for="searchByBin">Bin</label>
                <input type="text" name="searchByBin" id="searchByBin" class="form-control form-control-sm">
              </div>
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <label for="searchByUser">User</label>
                <select name="_pauser" id="_pauser" class="form-select form-select-sm">
                      <option value="">Select</option>
                      <?php
                      require(__DIR__ . '../../../dbconnect/db.php');

                      $sql = "SELECT * FROM INB_USERMASTER ORDER BY fname ASC";

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
              </div>
            </div>

            <!-- close body -->
          </div>
        </div>
        <div class="card mb-3">
          <div class="card-body pt-0 pt-md-3">
            <table id='vehiclesTable' class="table table-striped table-hover dt-responsive display compact font-sans-serif fs--1 custFontSize" style="width: 100% !important">
              <thead>
                <tr>
                  <th>PO&nbsp;Number</th>
                  <th>Stock&nbsp;Plate</th>
                  <th>Product&nbsp;Code</th>
                  <th>Product&nbsp;Description</th>
                  <th>Putaway&nbsp;Qty</th>
                  <th>Putaway&nbsp;Bin</th>
                  <th>Putaway&nbsp;On</th>
                  <th>Putaway&nbsp;By</th>
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
      'searching': false, // Remove default Search Control
      'lengthMenu': [
        [20, 50, 100, 500],
        [20, 50, 100, 500]
      ],
      'ajax': {
        'url': 'data.php',
        'data': function(data) {
          // Read values
          data.searchByPO = $('#searchByPO').val();
          data.searchByName = $('#searchByName').val();
          data.searchByBin = $('#searchByBin').val();
          data.searchByDescription = $('#searchByDescription').val();
          data.searchByUser = $('#_pauser option:selected').val();
        }
      },
      'columnDefs': [
        { "targets": [7], "className": "text-center"},
        { "targets": [4, 5], "className": "text-end"},
        { "targets": [3 ,6], "className": "text-nowrap"}
      ],
      'columns': [{
          data: 'PONumber'
        },
        {
          data: 'PlateNumber'
        },
        {
          data: 'ProductCode'
        },
        {
          data: 'ProductDescription'
        },
        {
          data: 'PutawayQuantity'
        },
        {
          data: 'PutawayLocation'
        },
        {
          data: 'PutawayTimeStamp'
        },
        {
          data: 'PutawayUser'
        }
      ],
    });


    $('select').change(function() {
      requestFromFilter = 1
      dataTable.draw();
    });

    $('input[type="text"]').keyup(function() {
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
</script>