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
                    <h5 class="card-header-title mb-0 col-12">Stock Control</h5><div><span class='badge badge-sm' style='background-color: var(--falcon-red)'>beta release 1.0</span></div>
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
                <label for="searchByActiveStatus">Active</label>
                <select class="form-select form-select-sm" name="searchByActiveStatus" id="searchByActiveStatus" aria-label=".form-select-sm example">
                  <option selected value="">All</option>
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
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
                <label for="searchByName">Barcode</label>
                <input type="text" name="searchByBarcode" id="searchByBarcode" class="form-control form-control-sm">
              </div>
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <label for="searchByCategory">Category</label>
                <select class="form-select form-select-sm" name="searchByCategory" id="searchByCategory" aria-label=".form-select-sm example">
                  <option value="">Select</option>
                <?php
                      require(__DIR__ . '../../../dbconnect/db.php');

                      $sql = "SELECT distinct(CustomFieldOne) as 'CustomFieldOne' FROM INB_PRODUCT_MASTER GROUP BY CustomFieldOne ORDER BY CustomFieldOne ASC";

                      $stmt = $conn->prepare($sql);
                      // $stmt->bind_param("s", $search);
                      // $search = $findOrder;
                      $stmt->execute();
                      $result = $stmt->get_result();

                      if (mysqli_num_rows($result) > 0) {
                        while ($row = $result->fetch_assoc()) {
                          echo '<option value=' . $row["CustomFieldOne"] . '>' . $row["CustomFieldOne"] . '</option>';
                        }
                      } else {
                        echo "error";
                      }    ?>
                </select>
              </div>
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <label for="searchByVendor">Vendor</label>
                <select class="form-select form-select-sm" name="searchByVendor" id="searchByVendor" aria-label=".form-select-sm example">
                  <option value="">Select</option>
                <?php
                      require(__DIR__ . '../../../dbconnect/db.php');

                      $sql = "SELECT distinct(Vendor) as 'Vendor' FROM INB_PRODUCT_MASTER WHERE Vendor IS NOT NULL ORDER BY Vendor ASC";

                      $stmt = $conn->prepare($sql);
                      // $stmt->bind_param("s", $search);
                      // $search = $findOrder;
                      $stmt->execute();
                      $result = $stmt->get_result();

                      if (mysqli_num_rows($result) > 0) {
                        while ($row = $result->fetch_assoc()) {
                          echo '<option value="' . $row["Vendor"] . '">' . $row["Vendor"] . '</option>';
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
            <table id='stockControl_table' class="table table-striped table-hover dt-responsive display compact font-sans-serif fs--1 custFontSize" style="width: 100% !important">
              <thead>
                <tr>
                  <th>Product&nbsp;Code</th>
                  <th>Description</th>
                  <th>Barcode</th>
                  <th>Category</th>
                  <th>IsActive</th>
                  <th>Pickface&nbsp;Stock</th>
                  <th>Bulk&nbsp;Stock</th>
                  <th>Total&nbsp;Stock</th>
                  <th>Allocated</th>
                  <th>Available&nbsp;</th>
                  <th>Vendor</th>
                  <th>Vendor&nbsp;Product&nbsp;ID</th>
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
    var dataTable = $('#stockControl_table').DataTable({
      'responsive': false,
      'scrollX': true,
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
          data.searchByActiveStatus = $('#searchByActiveStatus').val();
          data.searchByName = $('#searchByName').val();
          data.searchByCategory = $('#searchByCategory').val();
          data.searchByDescription = $('#searchByDescription').val();
          data.searchByBarcode = $('#searchByBarcode').val();
          data.searchByVendor = $('#searchByVendor').val();
        }
      },
      'columnDefs': [
        // { "targets": [5], "className": "text-center"},
        { "targets": 5, "className": "px200"},
        { "targets": [5, 6, 7, 8, 9], "className": "text-end"},
        { "targets": [1, 3 ,10, 11], "className": "text-nowrap"}
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
          data: 'Category'
        },
        {
          data: 'Active'
        },
        {
          data: 'PickfaceStock'
        },
        {
          data: 'BulkStock'
        },
        {
          data: 'TotalStock'
        },
        {
          data: 'Allocated'
        },
        {
          data: 'FreeStockOnShelf'
        },
        {
          data: 'Vendor'
        },
        {
          data: 'VendorProductCode'
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

  // $('#searchByVendor').on('change', function(xcc) {
  //   xcc.preventDefault();
  //   alert($('#searchByVendor').val());
  // })
</script>