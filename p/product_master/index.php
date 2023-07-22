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
                    <h5 class="card-header-title mb-0 col-12">Product List</h5>
                  </div>
                </div>
              </div>
              <!-- <div class="col-2 ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as read</a></div> -->
            </div>
          </div>
          <div class="card-body position-relative">
            <!-- Body -->
            <div class="row">
              <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 pe-1">
                <label for="searchByActiveStatus">Active</label>
                <select class="form-select form-select-sm" name="searchByActiveStatus" id="searchByActiveStatus" aria-label=".form-select-sm example">
                  <option selected value="">All</option>
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
              </div>
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 px-1">
                <label for="searchByName">Product&nbsp;Code</label>
                <input type="text" name="searchByName" id="searchByName" class="form-control form-control-sm">
              </div>
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 px-1">
                <label for="searchByName">Description</label>
                <input type="text" name="searchByDescription" id="searchByDescription" class="form-control form-control-sm">
              </div>
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 px-1">
                <label for="searchByName">Barcode</label>
                <input type="text" name="searchByBarcode" id="searchByBarcode" class="form-control form-control-sm">
              </div>
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 px-1">
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
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 px-1">
                <label for="searchByGroup">Group</label>
                <select class="form-select form-select-sm" name="searchByGroup" id="searchByGroup" aria-label=".form-select-sm example">
                  <option value="">Select</option>
                  <?php
                  require(__DIR__ . '../../../dbconnect/db.php');

                  $sql = "SELECT distinct(CustomFieldTwo) as 'CustomFieldTwo' FROM INB_PRODUCT_MASTER WHERE CustomFieldTwo IS NOT NULL GROUP BY CustomFieldTwo ORDER BY CustomFieldTwo ASC";

                  $stmt = $conn->prepare($sql);
                  // $stmt->bind_param("s", $search);
                  // $search = $findOrder;
                  $stmt->execute();
                  $result = $stmt->get_result();

                  if (mysqli_num_rows($result) > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo '<option value=' . $row["CustomFieldTwo"] . '>' . $row["CustomFieldTwo"] . '</option>';
                    }
                  } else {
                    echo "error";
                  }    ?>
                </select>
              </div>
              <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 px-1">
                <label for="fetchnewdata_">&nbsp;</label>
                <div name="fetchnewdata_" id="fetchnewdata_">
                  <input type="button" name="fetchnewdata" id="fetchnewdata" class="btn btn-sm btn-falcon-default" value="Update">
                </div>
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
                  <th>Product&nbsp;Code</th>
                  <th>Description</th>
                  <th>Barcode</th>
                  <th>Category</th>
                  <th>Group</th>
                  <th>Is Active</th>
                  <th>UOM</th>
                  <th>OBS</th>
                  <th>ALPA</th>
                  <th>CEQ</th>
                  <th>Wholesale</th>
                  <th>Staff</th>
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

    <div class="modal fade" id="detailsManager_" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="delailsManager" aria-hidden="true">
      <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
          <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" id="notesPopupclose" aria-label="Close"></button></div>
          <div class="modal-body p-0">
            <div class="bg-light rounded-top-lg py-3 ps-4 pe-6 modal-header">
              <h4 class="mb-1" id="delailsManager">Product Details</h4>
              <!-- <p class="fs--2 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
            </div>
            <div class="p-4">
              <div class="row">
                <div class="col-lg-12">
                  <!-- <div class="d-flex"> -->
                  <div class="col-lg-12" id="datat_">
                    <table id="productDet" class="table table-striped table-hover dt-responsive display compact font-sans-serif fs--1 custFontSize">
                      <thead>
                        <tr>
                          <th class="yourTableTh">Barcode</th>
                          <th class="yourTableTh">...</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                  <div class="flex-1">
                    <input type="hidden" id="code_">
                    <h3 class="mb-2 fs-0 readnotes" style="color: var(--falcon-gray)"></h3>
                  </div>
                  <!-- </div> -->
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="closePopup">Close</button>
              <!-- <button id="confDel" type="button" class="btn btn-danger">Confirm Delete?</button> -->
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
          data.searchByActiveStatus = $('#searchByActiveStatus').val();
          data.searchByName = $('#searchByName').val();
          data.searchByCategory = $('#searchByCategory').val();
          data.searchByDescription = $('#searchByDescription').val();
          data.searchByBarcode = $('#searchByBarcode').val();
          data.searchByGroup = $('#searchByGroup').val();
        }
      },
      'columnDefs': [{
          "targets": [5],
          "className": "text-center"
        },
        {
          "targets": [7, 8, 9, 10, 11],
          "className": "text-end"
        },
        {
          "targets": [1, 3, 4],
          "className": "text-nowrap"
        }
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
          data: 'CustomFieldOne'
        },
        {
          data: 'CustomFieldTwo'
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
          data: 'CEQ'
        },
        {
          data: 'Wholesale'
        },
        {
          data: 'Staff'
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

  $('#fetchnewdata').on('click', function(edf) {
    edf.preventDefault();
    $('#fetchnewdata').prop('value', 'Wait...');
    $.ajax({
      type: "POST",
      // data: $('#_as_po').serialize(),
      url: "https://workspace.inbracket.com/INB_OUT/API/GRWILLS/_fetch_products.php",
      success: function(msgx) {
        if (msgx == 'ProductsLoaded') {
          alert('Success!');
          $('#fetchnewdata').prop('value', 'Update');
        } else {
          alert('Snap! Update didn&apos;t go through well. Please try again');
          $('#fetchnewdata').prop('value', 'Update');
        }
      }
    })
  });

  $('#detailsManager_').on('shown.bs.modal', function(bsmx) {
    bsmx.preventDefault();
    // alert('test');
    var searchcode = $('#code_').val();
    $.ajax({
      type: "POST",
      data: {
        searchc: searchcode
      },
      dataType: 'json',
      cache: false,
      url: "fetchplu.php",
      success: function(data) {
        // res = data;
        var event_data = '';
        var items = '';
        $.each(data, function(i, item) {
          event_data += '<tr>';
          event_data += '<td>' + item.bc + '</td>';
          event_data += '<td><a href="#" class="bcdelete" id=' + item.bc + ' idd=' + searchcode + '>Delete</a></td>';
          event_data += '<tr>';
        });
        $('#productDet tbody').append(event_data);

        // window.location.href = "/Home/Details/" + data.id;
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $("#datat_").val(jqXHR.statusText);
      }
    })
  });

  $('#vehiclesTable').on('click', '.codeFlag_', function(cv) {
    cv.preventDefault();
    $('#code_').val($(this).attr('id'));
    $('#detailsManager_').modal('show');
  });

  $('#closePopup').on('click', function(ccd) {
    ccd.preventDefault();
    $('#detailsManager_').modal('hide');
    $("#detailsManager_ td").remove();
  });

  $('#notesPopupclose').on('click', function(ccxd) {
    ccxd.preventDefault();
    $('#detailsManager_').modal('hide');
    $("#detailsManager_ td").remove();
  });

  // 
  $('#productDet').on('click', '.bcdelete', function(bg){
    bg.preventDefault();
    var c = $(this).attr('id');
    var d = $(this).attr('idd');
    
    $.ajax({
      type: "POST",
      url: "delete.php",
      data: {
        plutodel: c,
        code: d
      },
      success: function(msgx) {
        if (msgx === 'deleted') {
         
          $("#detailsManager_ td").remove();
          var searchcode = $('#code_').val();
          $.ajax({
            type: "POST",
            data: {
              searchc: searchcode
            },
            dataType: 'json',
            cache: false,
            url: "fetchplu.php",
            success: function(data) {
              // res = data;
              var event_data = '';
              var items = '';
              $.each(data, function(i, item) {
                event_data += '<tr>';
                event_data += '<td>' + item.bc + '</td>';
                event_data += '<td><a href="#" class="bcdelete" id=' + item.bc + ' idd=' + searchcode + '>Delete</a></td>';
                event_data += '<tr>';
              });
              $('#productDet tbody').append(event_data);
              $('#vehiclesTable').DataTable().ajax.reload();
              // window.location.href = "/Home/Details/" + data.id;
            },
            error: function(jqXHR, textStatus, errorThrown) {
              $("#datat_").val(jqXHR.statusText);
            }
          })

        } else {
          alert('delete error');
        }
      }
    })

  }); 
</script>