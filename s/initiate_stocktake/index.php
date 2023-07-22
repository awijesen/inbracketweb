<?php

session_start();
if (!isset($_SESSION['LOGGED'])) {
  header('Location: ../../');
}
?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<?php include('../../p/common/header.html'); ?>


<body>

  <!-- ===============================================-->
  <!--    Main Content-->
  <!-- ===============================================-->
  <main class="main" id="top">
    <div class="container" data-layout="container">
      <script>
        var isFluid = JSON.parse(localStorage.getItem('isFluid'));
        if (isFluid) {
          var container = document.querySelector('[data-layout]');
          container.classList.remove('container');
          container.classList.add('container-fluid');
        }
      </script>


      <div class="content">
        <?php include('../../menu/sub_nav.php'); ?>

        <div class="card mb-3">
          <!--/.bg-holder-->
          <div class="card-header bg-light">
            <div class="row justify-content-between align-items-center">
              <div class="col-10">
                <div class="row">
                  <div class="col-3">
                    <h5 class="card-header-title mb-0 col-12">Initiate Stocktake</h5>
                  </div>
                </div>
              </div>
              <div class="col-2 ps-0 ps-sm-3"><a class="card-link fw-normal" id="_pause" href="#">Pause</a></div>
            </div>
          </div>
          <div class="card-body position-relative">
            <!-- Body -->
            <div>
              <div class="d-flex flex-row col-lg-4 col-md-4 mb-2">
                <select name="_slist" id="_slist" class="form-select form-select-sm">
                  <option value="selectsn">Select Snapshot</option>
                  <?php
                  require(__DIR__ . '../../../dbconnect/db.php');

                  $sql = "SELECT distinct(StocktakeID) FROM INB_STOCKTAKE_SNAPSHOT";

                  $stmt = $conn->prepare($sql);
                  // $stmt->bind_param("s", $search);
                  // $search = $findOrder;
                  $stmt->execute();
                  $result = $stmt->get_result();

                  if (mysqli_num_rows($result) > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo '<option value=' . $row["StocktakeID"] . '>' . $row["StocktakeID"] . '</option>';
                    }
                  } else {
                    echo "error";
                  }    ?>

                </select>
                <button id="_snaplist" type="button" class="btn btn-falcon-primary btn-sm ms-2">Start</button>
                <button id="_delete" type="button" class="btn btn-falcon-primary btn-sm ms-2"><i class="fa-solid fa-trash"></i></button>
              </div>
            </div>
            <div id="going-live"></div>
            <div>
              <div id="running-msg-3" class="font-sans-serif fs--1 mt-2"></div>
            </div>
            <div>
              <button class="btn btn-danger btn-sm" name="complete_" id="complete_">Finalize Stocktake</button>
            </div>
            <div>
              <div class="d-flex flex-row col-lg-4 col-md-4">
                <select name="_warehouse" id="_warehouse" class="form-select form-select-sm">
                  <option value="selectwh">Select Warehouse</option>
                  <?php
                  require(__DIR__ . '../../../dbconnect/db.php');

                  $sql = "SELECT WarehouseName, WarehouseId FROM INB_WAREHOUSES ORDER BY WarehouseName ASC";

                  $stmt = $conn->prepare($sql);
                  // $stmt->bind_param("s", $search);
                  // $search = $findOrder;
                  $stmt->execute();
                  $result = $stmt->get_result();

                  if (mysqli_num_rows($result) > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo '<option value=' . $row["WarehouseId"] . '>' . $row["WarehouseName"] . '</option>';
                    }
                  } else {
                    echo "error";
                  }    ?>

                </select>
                <button id="_build_stocktake" type="button" class="btn btn-falcon-primary btn-sm ms-2">Initiate</button>
              </div>
              <div id="error_1" class="font-sans-serif fs--1 mt-2" style="color:var(--falcon-red); font-size: 13px !important;"></div>
              <div class="col-lg-4 col-md-4">
                <div class="d-flex flex-row mt-3">
                  <div id="prepdoc" class="font-sans-serif fs--1 pe-2">Preparing</div>
                  <div class="spinner_container"><i id="prepdocspin" class="fas fa-spinner fa-spin"></i></div>
                </div>
                <div id="review-header" class="font-sans-serif fs--1 mt-2" style="color:var(--falcon-blue); font-weight:600">Reviewing invetory reports...</div>

                <div class="d-flex flex-row">
                  <div id="nsoh-main" class="font-sans-serif fs--1 mt-2">Negative stock on hand report</div>
                  <div class="mt-1 ms-2">
                    <span id="nsoh-clear" class="badge badge-soft-success">Clear</span>
                    <span id="nsoh-tbc" class="badge badge-soft-danger">To be cleared</span>
                  </div>
                </div>

                <div class="d-flex flex-row">
                  <div id="npa-main" class="font-sans-serif fs--1 mt-2">Non putaway report</div>
                  <div class="mt-1 ms-2">
                    <span id="npa-clear" class="badge badge-soft-success">Clear</span>
                    <span id="npa-tbc" class="badge badge-soft-danger">To be cleared</span>
                  </div>
                </div>

                <div class="d-flex flex-row">
                  <div id="review-main" class="font-sans-serif fs--1 mt-2">Pick review report</div>
                  <div class="mt-1 ms-2">
                    <span id="review-clear" class="badge badge-soft-success">Clear</span>
                    <span id="review-tbc" class="badge badge-soft-danger">To be cleared</span>
                  </div>
                </div>

                <div class="d-flex flex-row">
                  <div id="inv-main" class="font-sans-serif fs--1 mt-2">Pending invoices report</div>
                  <div class="mt-1 ms-2">
                    <span id="inv-clear" class="badge badge-soft-success">Clear</span>
                    <span id="inv-tbc" class="badge badge-soft-danger">To be cleared</span>
                  </div>
                </div>


                <div id="stage_1_complete" class="font-sans-serif fs--1 mt-2" style="color:var(--falcon-blue); font-weight:600">Review completed.</div>
                <div id="review-header-users" class="font-sans-serif fs--1 mt-2" style="color:var(--falcon-blue); font-weight:600">Review stage 2 in progress...</div>

                <div class="d-flex flex-row mt-3">
                  <div id="prepdoc2" class="font-sans-serif fs--1 pe-2">Preparing</div>
                  <div class="spinner_container2"><i id="prepdocspin" class="fas fa-spinner fa-spin"></i></div>
                </div>

                <table id="records_table" class="table table-sm table-striped table-hover font-sans-serif fs--1 mt-2">
                  <thead>
                    <tr>
                      <th scope="col">User</th>
                      <th scope="col">HHD</th>
                      <th scope="col">Web</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>

                <div id="review-header-users-completed" class="font-sans-serif fs--1 mt-2" style="color:var(--falcon-blue); font-weight:600">Review stage 2 completed</div>

                <div id="select-chamber-text" class="font-sans-serif fs--1 mt-2 mb-2">Select stocktake chamber</div>

                <div class="d-flex flex-row">
                  <select name="chamber" id="chamber" class="form-select form-select-sm">
                    <option value="selectcmb">Select Chamber</option>
                    <option value="allchambers">All Chambers</option>
                    <?php
                    require(__DIR__ . '../../../dbconnect/db.php');

                    $sql = "SELECT 
                  CustomFieldTwo
                  FROM INB_PRODUCT_MASTER
                  WHERE CustomFieldTwo is not null
                  GROUP BY CustomFieldTwo
                  ORDER BY CustomFieldTwo ASC";

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
                  <button id="_chamber_confirm" type="button" class="btn btn-falcon-primary btn-sm ms-2">Confirm</button>
                </div>

                <div id="confirmed-chamber-text" class="font-sans-serif fs--1 mt-2"></div>

                <div id="snap_source_header" class="font-sans-serif fs--1 mt-2 mb-2">Select snapshot source</div>
                <div class="d-flex flex-row">
                  <select id="choosesource" name="choosesource" class="form-select form-select-sm">
                    <option value="defselect">Select</option>
                    <option value="Inbracket">Inbracket</option>
                    <option value="ERP">ERP</option>
                  </select>
                  <button id="snap_source_confirm" type="button" class="btn btn-falcon-primary btn-sm ms-2">Confirm</button>
                </div>
                <div id="snap_source_confirmed_msg" class="font-sans-serif fs--1 mt-2"></div>
                <button id="generate_snap" class="btn-primary btn-sm mt-2">Generate Stocktake Snapshot</button>
                <div class="d-flex flex-row mt-3">
                  <div id="prepdoc3" class="font-sans-serif fs--1 pe-2">Preparing</div>
                  <div class="spinner_container3"><i id="prepdocspin" class="fas fa-spinner fa-spin"></i></div>
                </div>

                <div id="running-msg-1" class="font-sans-serif fs--1 mt-2"></div>
                <div id="running-msg-2" class="font-sans-serif fs--1 mt-2"></div>
              </div>


            </div>



            <!-- close body -->
          </div>
        </div>
        <footer class="footer" style="font-family: 'Poppins'; font-size: 13px">
          <!-- footer -->
        </footer>
      </div>

    </div>
    <div class="modal fade" id="deleteSnapshot" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="deleteSnapshotLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
          <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" id="deletemodalclose" aria-label="Close"></button></div>
          <div class="modal-body p-0">
            <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
              <h4 class="mb-1" id="deleteSnapshotLabel">Delete Stocktake Snapshot</h4>
              <!-- <p class="fs--2 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
            </div>
            <div class="p-4">
              <div class="row">
                <div class="col-lg-12">
                  <!-- <div class="d-flex"> -->
                  <div class="flex-1">
                    <h5 class="mb-2 fs-0">Are you sure you want to delete the stocktake snapshot?</h5>
                    <h6 class="mb-2 fs--1">This action can not be undone.</h6>
                    <div class="errMsg11" style="font-size: 13px; color:orange; margin-top: 6px;"></div>
                  </div>
                  <!-- </div> -->
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="delete_snap">Delete</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- stocktake finalize modal -->
    <div class="modal fade" id="finalizeStk" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="finalizeStkLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
          <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" id="stkmodalclose" aria-label="Close"></button></div>
          <div class="modal-body p-0">
            <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
              <h4 class="mb-1" id="finalizeStkLabel">Finalize Stocktake</h4>
              <!-- <p class="fs--2 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
            </div>
            <div class="p-4">
              <div class="row">
                <div class="col-lg-12">
                  <!-- <div class="d-flex"> -->
                  <div class="flex-1">
                    <input type="text" id="stk_num">
                    <h5 class="mb-2 fs-0">Are you sure you want to finalize the stocktake?</h5>
                    <h6 class="mb-2 fs--1">This action can not be undone.</h6>
                    <p class="font-sans-serif fs--1">Finalizing stocktake will end the stocktake process. All existing inventory data will be replaced with new stocktake counts.</p>
                    <br />
                    <p class="font-sans-serif fs--1"><b>Stocktake summary:</b></p>
                    <table id="jquery-datatable-ajax-php" class="table table-striped table-hover dt-responsive display compact font-sans-serif fs--1" style="width: 100% !important">
                      <thead>
                        <tr>
                          <th>Item</th>
                          <th>Summary</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Snapshot line count</td>
                          <td id="d1"></td>
                        </tr>
                        <tr>
                          <td>Snapshot inventory value</td>
                          <td id="d2"></td>
                        </tr>
                        <tr>
                          <td>Stocktake line count</td>
                          <td id="d3"></td>
                        </tr>
                        <tr>
                          <td>Stocktake inventory value</td>
                          <td id="d4"></td>
                        </tr>

                      </tbody>
                    </table>
                    <div class="d-flex flex-row">
                      <div id="running-msg-11" class="font-sans-serif fs--1 mt-2">Finalizing stocktake. Please wait..</div>
                      <div class="spinner_11 mt-1 ms-2"><i id="spinner_11" class="fas fa-spinner fa-spin"></i></div>
                    </div>

                    <div class="d-flex flex-row">
                      <div id="running-msg-12" class="font-sans-serif fs--1 mt-2">Clearing old data</div>
                      <div class="spinner_12 mt-1 ms-2"><i id="spinner_12" class="fas fa-spinner fa-spin"></i></div>
                    </div>

                    <div class="d-flex flex-row">
                      <div id="running-msg-13" class="font-sans-serif fs--1 mt-2">Copying stocktake data</div>
                      <div class="spinner_13 mt-1 ms-2"><i id="spinner_13" class="fas fa-spinner fa-spin"></i></div>
                    </div>

                    <div class="d-flex flex-row">
                      <div id="running-msg-14" class="font-sans-serif fs--1 mt-2 mb-2">Stocktake finalized.</div>
                    </div>

                    <div class="errMsg11" style="font-size: 13px; color:orange; margin-top: 6px;"></div>
                  </div>
                  <!-- </div> -->
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" id="close_stk">Close</button>
              <button type="button" class="btn btn-primary" id="finalize_stk">Confirm</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- stocktake finalize modal close -->
  </main>
  <!-- ===============================================-->
  <!--    End of Main Content-->
  <!-- ===============================================-->


  <!-- ===============================================-->
  <!--    JavaScripts-->
  <!-- ===============================================-->
  <?php include('../../p/common/footer.html'); ?>
</body>

</html>

<script>
  $(document).ready(function() {



    $.ajax({
      type: "POST",
      url: "_gateway.php",
      success: function(note) {
        if (note === 'available') {
          $('#_slist').show();
          $('#_snaplist').show();
          $('#_warehouse').hide();
          $('#_build_stocktake').hide();
          $('#_delete').show();
        } else if (note === 'unavailable') {
          $('#_warehouse').show();
          $('#_build_stocktake').show();
          $('#_slist').hide();
          $('#_snaplist').hide();
          $('#_delete').hide();
        }
      }
    });

    $('#close_stk').hide();
    $('#running-msg-11').hide();
    $('#spinner_11').hide();
    $('.spinner_11').hide();
    $('#running-msg-12').hide();
    $('#spinner_12').hide();
    $('.spinner_12').hide();
    $('#running-msg-13').hide();
    $('#spinner_13').hide();
    $('.spinner_13').hide();
    $('#running-msg-14').hide();
    $('#going-live').hide();
    $('#review-main').hide();
    $('#review-clear').hide();
    $('#review-tbc').hide();
    $('#inv-main').hide();
    $('#inv-clear').hide();
    $('#inv-tbc').hide();
    $('#_slist').hide();
    $('#_snaplist').hide();
    $('#_delete').hide();
    $('#_warehouse').hide();
    $('#_build_stocktake').hide();
    $('#running-msg-1').hide();
    $('#running-msg-2').hide();
    $('#generate_snap').hide();
    $('#snap_source_header').hide();
    $('#choosesource').hide();
    $('#snap_source_confirm').hide();
    $('#snap_source_confirmed_msg').hide();
    $('#confirmed-chamber-text').hide();
    $('#select-chamber-text').hide();
    $('#_chamber_confirm').hide();
    $('#chamber').hide();
    $("#prepdoc").hide();
    $("#prepdocspin").hide();
    $("#prepdoc2").hide();
    $("#prepdocspin2").hide();
    $("#prepdoc3").hide();
    $("#prepdocspin3").hide();
    $('.spinner_container').hide();
    $('.spinner_container2').hide();
    $('.spinner_container3').hide();
    $('#nsoh-main').hide();
    $('#nsoh-clear').hide();
    $('#nsoh-tbc').hide();
    $('#npa-clear').hide();
    $('#npa-tbc').hide();
    $('#npa-main').hide();
    $('#review-header').hide();
    $('#stage_1_complete').hide();
    $('#review-header-users').hide();
    $('#records_table').hide();
    $('#review-header-users-completed').hide();

    $.ajax({
      type: "POST",
      url: "_stocktake_live_check.php",
      success: function(resp) {
        if (resp === 'On') {
          $('#going-live').show();
          $('#going-live').html('<div class="col-lg-4 col-md-4 mb-2 alert alert-success" role="alert">Stocktake is Live</div>');
        } else {
          $('#going-live').hide();
          $('#going-live').html('');
        }
      }
    });

    $('#_build_stocktake').on('click', function(fg) {
      fg.preventDefault();

      $('#going-live').hide();
      $('#inv-main').hide();
      $('#inv-clear').hide();
      $('#inv-tbc').hide();
      $('#running-msg-1').hide();
      $('#running-msg-2').hide();
      $('#records_table tbody').empty();
      $('#generate_snap').hide();
      $('#snap_source_header').hide();
      $('#choosesource').hide();
      $('#snap_source_confirm').hide();
      $('#snap_source_confirmed_msg').hide();
      $('#confirmed-chamber-text').hide();
      $('#select-chamber-text').hide();
      $('#_chamber_confirm').hide();
      $('#chamber').hide();
      $("#prepdoc").hide();
      $("#prepdocspin").hide();
      $("#prepdoc2").hide();
      $("#prepdocspin2").hide();
      $('.spinner_container').hide();
      $('.spinner_container2').hide();
      $('.spinner_container3').hide();
      $('#nsoh-main').hide();
      $('#nsoh-clear').hide();
      $('#nsoh-tbc').hide();
      $('#review-main').hide();
      $('#review-clear').hide();
      $('#review-tbc').hide();
      $('#npa-clear').hide();
      $('#npa-tbc').hide();
      $('#npa-main').hide();
      $('#review-header').hide();
      $('#stage_1_complete').hide();
      $('#review-header-users').hide();
      $('#records_table').hide();
      $('#review-header-users-completed').hide();
      $('#choosesource').prop('selectedIndex', 0);
      $('#chamber').prop('selectedIndex', 0);

      var selectedWH = $('#_warehouse option:selected').val();
      if (selectedWH === 'selectwh') {
        $('#error_1').html('Select a warehouse to initiate the stocktake');
      } else {
        $('#error_1').html('');
        $('#prepdoc').show();
        $('#prepdocspin').show();
        $('.spinner_container').show();

        setTimeout(function() {
          $('#review-header').show();
        }, 3000);

        //check neative soh report
        $.ajax({
          type: "POST",
          url: "_check_nsoh.php",
          success: function(msg) {
            if (msg > 0) {
              setTimeout(function() {
                $('#nsoh-main').show();
                $('#nsoh-clear').hide();
                $('#nsoh-tbc').show();
              }, 5000);
            } else {
              setTimeout(function() {
                $('#npa-main').show();
                $('#nsoh-clear').show();
                $('#nsoh-tbc').hide();
              }, 5000);
            }
            // check non putaway report
            $.ajax({
              type: "POST",
              url: "_check_npa.php",
              success: function(msgx) {
                if (msgx > 0) {
                  setTimeout(function() {
                    $('#npa-main').show();
                    $('#npa-clear').hide();
                    $('#npa-tbc').show();
                  }, 6000);
                } else {
                  setTimeout(function() {
                    $('#npa-main').show();
                    $('#npa-clear').show();
                    $('#npa-tbc').hide();
                  }, 6000);
                }

                // check picks in review
                $.ajax({
                  type: "POST",
                  url: "_check_picksinreview.php",
                  success: function(msgax) {
                    if (msgax > 0) {
                      setTimeout(function() {
                        $('#review-main').show();
                        $('#review-clear').hide();
                        $('#review-tbc').show();
                      }, 8000);
                    } else {
                      setTimeout(function() {
                        $('#review-main').show();
                        $('#review-clear').show();
                        $('#review-tbc').hide();
                      }, 8000);
                    }

                    $.ajax({
                      type: "POST",
                      url: "_check_tobe_invoiced.php",
                      success: function(msin) {
                        if (msin > 0) {
                          setTimeout(function() {
                            $('#inv-main').show();
                            $('#inv-clear').hide();
                            $('#inv-tbc').show();
                          }, 10000);
                        } else {
                          setTimeout(function() {
                            $('#inv-main').show();
                            $('#inv-clear').show();
                            $('#inv-tbc').hide();
                          }, 10000);
                        }

                        setTimeout(function() {
                          if (msg > 0 || msgx > 0 || msgax > 0 || msin > 0) {
                            $('#stage_1_complete').html('Stage 1 review is completed. Clear reports prior to creating a stocktake');
                          } else {
                            $('#stage_1_complete').html('Stage 1 review is completed');
                            $('#review-header-users').show();
                            $('#prepdoc2').show();
                            $('#prepdocspin2').show();
                            $('.spinner_container2').show();
                            $('#select-chamber-text').hide();
                            $('#chamber').hide();
                            $('#_chamber_confirm').hide();

                            $.ajax({
                              type: "POST",
                              url: "_check_users.php",
                              success: function(msgc) {
                                if (msgc !== '0') {
                                  setTimeout(function() {
                                    $('#records_table tbody').empty();
                                    $('#records_table').hide();
                                    $('#review-header-users-completed').html('Stage 2 review is completed. No active login sessions found');
                                    $('#review-header-users').hide();
                                    $('#review-header-users-completed').show();
                                    $('#prepdoc2').hide();
                                    $('#prepdocspin2').hide();
                                    $('.spinner_container2').hide();
                                    $('#select-chamber-text').show();
                                    $('#chamber').show();
                                    $('#_chamber_confirm').show();
                                  }, 6000);
                                } else {
                                  setTimeout(function() {
                                    $('#records_table').show();
                                    response = $.parseJSON(msgc);
                                    if (response.length > 0) {
                                      // $(function() {
                                      $.each(response, function(i, item) {
                                        var $tr = $('<tr>').append(
                                          $('<td class="text-nowrap">').text(item.name),
                                          $('<td class="text-nowrap">').text(item.mob),
                                          $('<td class="text-nowrap">').text(item.web)
                                        ).appendTo('#records_table');
                                        // console.log($tr.wrap('<p>').html());
                                        $('#review-header-users-completed').html('Stage 2 review is completed. Below active sessions needs to be signed out prior to creating a stocktake');
                                        $('#review-header-users').hide();
                                        $('#review-header-users-completed').show();
                                        $('#prepdoc2').hide();
                                        $('#prepdocspin2').hide();
                                        $('.spinner_container2').hide();
                                        $('#select-chamber-text').hide();
                                        $('#chamber').hide();
                                        $('#_chamber_confirm').hide();

                                      });
                                    } else {
                                      $('#records_table tbody').empty();
                                      $('#records_table').hide();
                                      $('#review-header-users-completed').html('Stage 2 review is completed.. No active login sessions found');
                                      $('#review-header-users').hide();
                                      $('#review-header-users-completed').show();
                                      $('#prepdoc2').hide();
                                      $('#prepdocspin2').hide();
                                      $('.spinner_container2').hide();
                                    }
                                  }, 6000);
                                }
                              }
                            })

                          }
                          $("#prepdoc").hide();
                          $("#prepdocspin").hide();
                          $('.spinner_container').hide();
                          $('#review-header').hide();
                          $('#stage_1_complete').show();

                        }, 12000);

                      }
                    })
                  }
                })

              }
            })

          }
        });



        //check for NPA over
      }
    });

    $('#_chamber_confirm').on('click', function(cd) {
      cd.preventDefault();
      var selected_cmber = $('#chamber option:selected').val();
      var selected_cmber_txt = $('#chamber option:selected').text();
      if (selected_cmber === 'selectcmb') {
        $('#confirmed-chamber-text').html('<p style="color:var(--falcon-red)" class="font-sans-serif fs--1">Select the stocktake chamber</p>');
        $('#confirmed-chamber-text').show();
      } else {
        $('#confirmed-chamber-text').html(selected_cmber_txt + ' selected..');
        $('#confirmed-chamber-text').show();
        $('#snap_source_header').show();
        $('#choosesource').show();
        $('#snap_source_confirm').show();
        $('#snap_source_confirmed_msg').show();
      }
    })

    $('#snap_source_confirm').on('click', function(vb) {
      vb.preventDefault();
      var choosen = $('#choosesource option:selected').val();
      var selected_cmber_txt = $('#chamber option:selected').text();

      if (choosen === 'defselect') {
        $('#snap_source_confirmed_msg').html('<p style="color:var(--falcon-red)" class="font-sans-serif fs--1">Select the snapshot source</p>');
        $('#snap_source_confirmed_msg').show();
      } else if (choosen === 'Inbracket') {
        $('#snap_source_confirmed_msg').html('<p style="color:var(--falcon-red)" class="font-sans-serif fs--1">Inbracket snapshot is unavailable. Select ERP instead</p>');
        $('#snap_source_confirmed_msg').show();
      } else {
        $('#snap_source_confirmed_msg').html(selected_cmber_txt + ' prepared to take an inventory snapshot from ' + choosen);
        $('#snap_source_confirmed_msg').show();
        $('#generate_snap').show();
      }
    });

    $('#generate_snap').on('click', function(iu) {
      iu.preventDefault();
      $('#_build_stocktake').hide();
      $('#snap_source_confirm').hide();
      $('#_chamber_confirm').hide();
      $("#prepdoc3").show();
      $("#prepdocspin3").show();
      $('.spinner_container3').show();

      $.ajax({
        type: "POST",
        url: "../../INB_OUT/API/GRWILLS/_fetch_products.php",
        success: function(msgc) {
          var selected_cmber = $('#chamber option:selected').val();
          if (msgc === 'Error inserting products') {
            $('#running-msg-1').html('Error occured whilst generating stocktake snapshot. Please initiate again');
          } else if (msgc === 'ProductsLoaded') {
            $('#running-msg-1').show();
            $('#running-msg-1').html('Product master copied. Please wait..');
            if (selected_cmber === 'allchambers') {
              setTimeout(function() {
                $('#running-msg-2').show();
                $('#running-msg-1').show();
                $('#running-msg-1').html('Product master copied.');
                $('#running-msg-2').html('Building snapshot for all chambers. Please wait..');

                $.ajax({
                  type: "POST",
                  url: "_in_all.php",
                  success: function(msgcv) {
                    $('#running-msg-2').html(msgcv);
                    if (msgcv === 'Success!') {
                      setTimeout(function() {
                        location.reload();
                      }, 3000)
                    }
                  }
                })

              }, 4000);
            } else {
              setTimeout(function() {
                $('#running-msg-2').show();
                $('#running-msg-1').show();
                $('#running-msg-1').html('Product master copied.');
                $('#running-msg-2').html('Building a custom snapshot. Please wait..');

                $.ajax({
                  type: "POST",
                  url: "_in_custom.php",
                  data: {
                    cmbr: selected_cmber
                  },
                  success: function(msgcv) {
                    $('#running-msg-2').html(msgcv);
                    if (msgcv === 'Success!') {
                      setTimeout(function() {
                        location.reload();
                      }, 3000)
                    }
                  }
                })

              }, 4000);
            }
          }
        }
      })
    })

    $('#_delete').on('click', function(cd) {
      cd.preventDefault();
      var sn = $('#_slist option:selected').val();
      if (sn === 'selectsn') {
        alert('Select snapshot ID from the dropdown menu');
      } else {
        $('#deleteSnapshot').modal('show');
      }
    });

    $('#deletemodalclose').on('click', function(awc) {
      awc.preventDefault();
      $('#deleteSnapshot').modal('hide');
    });

    $('#stkmodalclose').on('click', function(awc) {
      awc.preventDefault();
      $('#finalizeStk').modal('hide');
      $('#stk_num').val('');
    });

    $('#delete_snap').on('click', function(sd) {
      sd.preventDefault();

      var sn = $('#_slist option:selected').val();
      if (sn === 'selectsn') {
        alert('Select snapshot ID from the dropdown menu');
      } else {
        $.ajax({
          type: "POST",
          url: "_clear.php",
          data: {
            snd: sn
          },
          success: function(v) {
            if (v === 'deleted') {
              $('#deleteSnapshot').modal('hide');
              location.reload();
            } else {
              alert('Error deleting the snapshot. Try again');
            }
          }
        })
      }
    })

    $('#_slist').on('change', function(cvf) {
      cvf.preventDefault();
      var captured = $('#_slist option:selected').val();

      if (captured === 'selectsn') {
        //
      } else {
        $.ajax({
          type: "POST",
          url: "_snap_summary.php",
          success: function(vbn) {
            var lines_ = jQuery.parseJSON(vbn);
            var value_ = jQuery.parseJSON(vbn)
            // alert(result[1].rec);
            if (vbn === 'error') {
              //
            } else {
              $('#running-msg-3').show();
              $('#running-msg-3').html('Snapshot contains total ' + lines_[0].rec + ' lines and a total cost value of : $' + value_[1].rec);
            }
          }
        })
      }
    });

    $('#finalizeStk').on('shown.bs.modal', function(cvf) {
      // alert('hello');
      // $('#_slist').on('change', function(cvf) {
      cvf.preventDefault();

      $('#finalize_stk').prop('disabled', false);

      $.ajax({
        type: "POST",
        url: "_stk_summary.php",
        success: function(vbnx) {
          var lines_ = jQuery.parseJSON(vbnx);
          var value_ = jQuery.parseJSON(vbnx)
          // alert(result[1].rec);
          if (vbnx === 'error') {
            //
          } else {
            $('#d1').html(lines_[0].data.toLocaleString(undefined, {
              'minimumFractionDigits': 0,
              'maximumFractionDigits': 0
            }));
            $('#d2').html(lines_[3].data.toLocaleString(undefined, {
              'minimumFractionDigits': 2,
              'maximumFractionDigits': 2
            }));
            $('#d3').html(lines_[1].data.toLocaleString(undefined, {
              'minimumFractionDigits': 0,
              'maximumFractionDigits': 0
            }));
            $('#d4').html(lines_[2].data.toLocaleString(undefined, {
              'minimumFractionDigits': 2,
              'maximumFractionDigits': 2
            }));
            // $('#running-msg-3').show();
            // alert('Snapshot contains total ' + lines_[0].data + ' lines and a total cost value of : $' + value_[1].data);
          }
        }
      })

    });

    $('#_snaplist').on('click', function(vn) {
      vn.preventDefault();
      var selection = $('#_slist option:selected').val();

      if (selection === 'selectsn') {
        alert('Please select the stocktake');
      } else {
        $.ajax({
          type: "POST",
          data: {
            sel: selection
          },
          url: "_stk_on.php",
          success: function(vbnc) {
            if (vbnc === 'active') {
              $('#_snaplist').hide();
              $('#_delete').hide();
              alert('Stocktake is ACTIVE');
              $('#going-live').show();
              $('#going-live').html('<div class="col-lg-4 col-md-4 mb-2 alert alert-success" role="alert">Stocktake is Live</div>');
            } else {
              alert('Stocktake activation error!');
            }
          }
        })
      }
    });

    $('#_pause').on('click', function(vn) {
      vn.preventDefault();
      var selection = $('#_slist option:selected').val();

      if (selection === 'selectsn') {
        alert('Please select the stocktake');
      } else {
        $.ajax({
          type: "POST",
          data: {
            sel: selection
          },
          url: "_stk_off.php",
          success: function(vbnc) {
            if (vbnc === 'inactive') {
              alert('Stocktake is PAUSED');
              location.reload();
            } else {
              alert('Stocktake activation error!');
            }
          }
        })
      }
    })

    $('#complete_').on('click', function(xv) {
      xv.preventDefault();
      var selection = $('#_slist option:selected').val();
      if(selection === 'selectsn')
      {
        alert('Select stocktake ID from dropdown menu');
      } else {
        $('#stk_num').val(selection);
        $('#finalizeStk').modal('show');
      }
    })

    $('#finalize_stk').on('click', function(afg) {
      afg.preventDefault();
      $('#finalize_stk').prop('disabled', true);
      $('#running-msg-11').show();
      $('#spinner_11').show();
      $('.spinner_11').show();

      setTimeout(() => {
        $('#spinner_11').hide();
        $('.spinner_11').hide();
        $('#running-msg-12').show();
        $('#spinner_12').show();
        $('.spinner_12').show();

        $.ajax({
          type: "POST",
          url: "_delete_existing_pf_inventory.php",
          success: function(bn) {
            setTimeout(() => {

              $.ajax({
                type: "POST",
                url: "_delete_existing_bk_inventory.php",
                success: function(bna) {
                  setTimeout(() => {
                    $('#running-msg-12').append(' : Completed.');
                    $('#spinner_12').hide();
                    $('.spinner_12').hide();

                    $('#running-msg-13').show();
                    $('#spinner_13').show();
                    $('.spinner_13').show();

                    $.ajax({
                      type: "POST",
                      url: "_insert_stocktake_data.php",
                      success: function(bnv) {
                        setTimeout(() => {
                          $('#running-msg-13').append(' : Completed.');
                          $('#spinner_13').hide();
                          $('.spinner_13').hide();

                          $('#running-msg-14').show();
                          $('#close_stk').show();
                          $('#finalize_stk').hide();
                        }, 2000)
                      }
                    });


                  }, 2000)
                }
              });

            }, 2000)
          }
        });

      }, 3000);
    });

    $('#close_stk').on('click', function(fg){
      fg.preventDefault();

      var selection = $('#_slist option:selected').val();

      if (selection === 'selectsn') {
        alert('Please select the stocktake');
      } else {
        $.ajax({
          type: "POST",
          data: {
            sel: selection
          },
          url: "_stk_off.php",
          success: function(vbnc) {
            if (vbnc === 'inactive') {
              alert('Stocktake is finalized');
              location.reload();
            } else {
              alert('Stocktake activation error!');
            }
          }
        })
      }
    })

  });
</script>