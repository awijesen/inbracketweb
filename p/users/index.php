<?php

session_start();
if (!isset($_SESSION['LOGGED'])) {
  header('Location: ../../');
}

// $orderToFetch = htmlspecialchars($_GET['link']);

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

        <div class="row mb-3">
          <div class="col">
            <div class="card bg-100 shadow-none border">
              <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-start"><img class="ms-n2" src="" alt="" width="20" />
                  <div>
                    <h4 class="text-primary fw-bold mb-0">Inbracket <span class="text-info fw-medium">User Profile Manager</span></h4>
                  </div><img class="ms-n4 d-md-none d-lg-block" src="../assets/img/illustrations/crm-line-chart.png" alt="" width="150" />
                </div>
                <div class="col-md-auto p-3 g-3">
                  <!-- <form class="row align-items-center g-3">
                      <div class="col-auto">
                        <h6 class="text-700 mb-0">Showing Data For: </h6>
                      </div>
                      <div class="col-md-auto position-relative">
                        <input class="form-control form-control-sm datetimepicker ps-4" id="CRMDateRange" type="text" data-options="{&quot;mode&quot;:&quot;range&quot;,&quot;dateFormat&quot;:&quot;M d&quot;,&quot;disableMobile&quot;:true , &quot;defaultDate&quot;: [&quot;Dec 07&quot;, &quot;Dec 14&quot;] }" /><span class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2"> </span>
                      </div>
                    </form> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-3 g-3">
          <div class="col-lg-12 col-xxl-9">
            <!-- <div class="card mb-3">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-4 border-lg-end border-bottom border-lg-0 pb-3 pb-lg-0">
                    <div class="d-flex flex-between-center mb-3">
                      <div class="d-flex align-items-center">
                        <div class="icon-item icon-item-sm bg-soft-primary shadow-none me-2 bg-soft-primary"><span class="fs--2 fas fa-phone text-primary"></span></div>
                        <h6 class="mb-0">New Contact</h6>
                      </div>
                      <div class="dropdown font-sans-serif btn-reveal-trigger">
                        <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-new-contact" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
                        <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-new-contact"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                          <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex">
                      <div class="d-flex">
                        <p class="font-sans-serif lh-1 mb-1 fs-4 pe-2">15%</p>
                        <div class="d-flex flex-column"> <span class="me-1 text-success fas fa-caret-up text-primary"></span>
                          <p class="fs--2 mb-0 text-nowrap">2500 vs 2683 </p>
                        </div>
                      </div>
                      <div class="echart-crm-statistics w-100 ms-2" data-echart-responsive="true" data-echarts='{"series":[{"type":"line","data":[220,230,150,175,200,170,70,160],"color":"#2c7be5","areaStyle":{"color":{"colorStops":[{"offset":0,"color":"#2c7be53A"},{"offset":1,"color":"#2c7be50A"}]}}}],"grid":{"bottom":"-10px"}}'></div>
                    </div>
                  </div>
                  <div class="col-lg-4 border-lg-end border-bottom border-lg-0 py-3 py-lg-0">
                    <div class="d-flex flex-between-center mb-3">
                      <div class="d-flex align-items-center">
                        <div class="icon-item icon-item-sm bg-soft-primary shadow-none me-2 bg-soft-info"><span class="fs--2 fas fa-user text-info"></span></div>
                        <h6 class="mb-0">New Users</h6>
                      </div>
                      <div class="dropdown font-sans-serif btn-reveal-trigger">
                        <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-new-users" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
                        <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-new-users"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                          <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex">
                      <div class="d-flex">
                        <p class="font-sans-serif lh-1 mb-1 fs-4 pe-2">13%</p>
                        <div class="d-flex flex-column"> <span class="me-1 text-success fas fa-caret-up text-success"></span>
                          <p class="fs--2 mb-0 text-nowrap">1635 vs 863 </p>
                        </div>
                      </div>
                      <div class="echart-crm-statistics w-100 ms-2" data-echart-responsive="true" data-echarts='{"series":[{"type":"line","data":[90,160,150,120,230,155,220,240],"color":"#27bcfd","areaStyle":{"color":{"colorStops":[{"offset":0,"color":"#27bcfd3A"},{"offset":1,"color":"#27bcfd0A"}]}}}],"grid":{"bottom":"-10px"}}'></div>
                    </div>
                  </div>
                  <div class="col-lg-4 pt-3 pt-lg-0">
                    <div class="d-flex flex-between-center mb-3">
                      <div class="d-flex align-items-center">
                        <div class="icon-item icon-item-sm bg-soft-primary shadow-none me-2 bg-soft-success"><span class="fs--2 fas fa-bolt text-success"></span></div>
                        <h6 class="mb-0">New Leads</h6>
                      </div>
                      <div class="dropdown font-sans-serif btn-reveal-trigger">
                        <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-new-leads" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
                        <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-new-leads"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                          <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex">
                      <div class="d-flex">
                        <p class="font-sans-serif lh-1 mb-1 fs-4 pe-2">16%</p>
                        <div class="d-flex flex-column"> <span class="me-1 text-success fas fa-caret-down text-danger"></span>
                          <p class="fs--2 mb-0 text-nowrap">1423 vs 256 </p>
                        </div>
                      </div>
                      <div class="echart-crm-statistics w-100 ms-2" data-echart-responsive="true" data-echarts='{"series":[{"type":"line","data":[200,150,175,130,150,115,130,100],"color":"#00d27a","areaStyle":{"color":{"colorStops":[{"offset":0,"color":"#00d27a3A"},{"offset":1,"color":"#00d27a0A"}]}}}],"grid":{"bottom":"-10px"}}'></div>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
            <div class="card">
              <div class="card-header d-flex flex-between-center ps-0 py-0 border-bottom">
                <ul class="nav nav-tabs border-0 flex-nowrap tab-active-caret" id="add-new-user-chart-tab" role="tablist" data-tab-has-echarts="data-tab-has-echarts">
                  <li class="nav-item" role="presentation"><a class="nav-link py-3 mb-0 active" id="add-new-user-tab" data-bs-toggle="tab" href="#add-new-user" role="tab" aria-controls="add-new-user" aria-selected="true">Add</a></li>
                  <li class="nav-item" role="presentation"><a class="nav-link py-3 mb-0" id="user-access-tab" data-bs-toggle="tab" href="#user-access" role="tab" aria-controls="user-access" aria-selected="false">Access</a></li>
                  <li class="nav-item" role="presentation"><a class="nav-link py-3 mb-0" id="user-manage-tab" data-bs-toggle="tab" href="#user-manage" role="tab" aria-controls="user-manage" aria-selected="false">Manage</a></li>
                  <li class="nav-item" role="presentation"><a class="nav-link py-3 mb-0" id="user-settings-master-tab" data-bs-toggle="tab" href="#user-settings-master" role="tab" aria-controls="user-settings-master" aria-selected="false">Settings</a></li>
                </ul>
                <div class="dropdown font-sans-serif btn-reveal-trigger">
                  <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-session-by-country" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-session-by-country"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row g-1">
                  <!-- <div class="col-xxl-3">
                      <div class="row g-0 my-2">
                        <div class="col-md-6 col-xxl-12">
                          <div class="border-xxl-bottom border-xxl-200 mb-2">
                            <h2 class="text-primary">$37,950</h2>
                            <p class="fs--2 text-500 fw-semi-bold mb-0"><span class="fas fa-circle text-primary me-2"></span>Closed Amount</p>
                            <p class="fs--2 text-500 fw-semi-bold"><span class="fas fa-circle text-warning me-2"></span>Revenue Goal</p>
                          </div>
                          <div class="form-check form-check-inline me-2">
                            <input class="form-check-input" id="crmInbound" type="radio" name="bound" value="inbound" Checked="Checked" />
                            <label class="form-check-label" for="crmInbound">Inbound</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" id="outbound" type="radio" name="bound" value="outbound" />
                            <label class="form-check-label" for="outbound">Outbound</label>
                          </div>
                        </div>
                        <div class="col-md-6 col-xxl-12 py-2">
                          <div class="row mx-0">
                            <div class="col-6 border-end border-bottom py-3">
                              <h5 class="fw-normal text-600">$4.2k</h5>
                              <h6 class="text-500 mb-0">Email</h6>
                            </div>
                            <div class="col-6 border-bottom py-3">
                              <h5 class="fw-normal text-600">$5.6k</h5>
                              <h6 class="text-500 mb-0">Social</h6>
                            </div>
                            <div class="col-6 border-end py-3">
                              <h5 class="fw-normal text-600">$6.7k</h5>
                              <h6 class="text-500 mb-0">Call</h6>
                            </div>
                            <div class="col-6 py-3">
                              <h5 class="fw-normal text-600">$2.3k</h5>
                              <h6 class="text-500 mb-0">Other</h6>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> -->
                  <div class="col-xxl-12">
                    <div class="tab-content">
                      <!-- Find the JS file for the following chart at: src/js/charts/echarts/add-new-user.js-->
                      <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                      <div class="tab-pane active" id="add-new-user" role="tabpanel" aria-labelledby="add-new-user-tab">
                        <div class="echart-add-new-user" data-echart-responsive="true" data-echart-tab="data-echart-tab" style="height:360px;">
                          <!-- ADD USER TAB OPEN -->
                          <div class="row">
                            <div class="mb-3 col-4">
                              <label for="fname">First name</label>
                              <input class="form-control" type="text" aria-label="fname" name="fname" id="fname" />
                            </div>
                            <div class="mb-3 col-4">
                              <label for="lname">Last name</label>
                              <input class="form-control" type="text" aria-label="lname" name="lname" id="lname" />
                            </div>
                            <div class="mb-3 col-4">
                              <label for="ucode">User code</label>
                              <input class="form-control" type="text" placeholder="Three letters only" aria-label="ucode" maxlength="3" name="ucode" id="ucode" />
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-4">
                              <label for="busemail">Business email</label>
                              <input class="form-control" type="email" aria-label="busemail" name="busemail" id="busemail" />
                            </div>
                            <div class="col-4">
                              <label for="inb-log">Platform login ID</label>
                              <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="User short code" aria-label="inb-log" aria-describedby="basic-addon2" name="platformid" id="platformid">
                                <span class="input-group-text" id="basic-addon2">@inb.com</span>
                              </div>
                            </div>
                            <div class="col-4">
                              <label for="accesslevel">Access Level</label>
                              <select class="form-select" name="accesslevel" id="accesslevel">
                                <option value="selectaccess">Set access level</option>
                                <option value="local_admin">L1 Access - Administrator</option>
                                <option value="local_manager">L2 Access - Warehouse Manager</option>
                                <option value="local_non_wh_st">L3 Access - Office Staff</option>
                                <option value="warehouse_staff">L4 Access - Warehouse Staff</option>
                              </select>
                            </div>
                          </div>
                          <div class="row">
                            <div class="mb-3 col-6">
                              <label for="pword">Password</label>
                              <input class="form-control" type="password" aria-label="pword" name="pw" id="pw" />
                            </div>
                            <div class="mb-3 col-6">
                              <label for="pword-confirm">Confirm Password</label>
                              <input class="form-control" type="password" aria-label="pword-confirm" name="repw" id="repw" />
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-2">
                              <button class="btn btn-primary btn-sm" type="submit" id="addnewuser">Add&nbsp;User</button>
                            </div>
                          </div>
                          <div class="row mt-3">
                            <div class="mb-3 col-12" id="alert-msg" style="color:var(--falcon-red); font-size: 13px; margin-top: 6px; font-family: var(--falcon-font-sans-serif)"></div>
                          </div>
                          <!-- ADD USER TAB CLOSE -->
                        </div>
                      </div>
                      <div class="tab-pane" id="user-access" role="tabpanel" aria-labelledby="user-access-tab">
                        <div class="echart-user-access" data-echart-responsive="true" data-echart-tab="data-echart-tab" style="height:360px;">

                          <div class="col-md-4 col-lg-4">
                            <div class="row">
                              <div class="col-md-6">
                                <select name="_upkr" id="_upkr" class="form-select form-select-sm" style="max-width: 200px; margin-bottom: 20px">
                                  <option value="selectpicker">Select user</option>
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
                              <div class="col-md-6">
                                <!-- </div> -->
                                <!-- <div class="col-md-4"> -->
                                <!-- Example single danger button -->
                                <div class="btn-group">
                                  <button type="button" class="btn btn-sm btn-falcon-default dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-cog"></i>
                                  </button>
                                  <ul class="dropdown-menu">
                                    <li><a class="dropdown-item fs--1 mb-0 font-sans-serif" href="#" id="ia">Deactivate User</a></li>
                                    <li><a class="dropdown-item fs--1 mb-0 font-sans-serif" href="#" id="ac">Activate User</a></li>
                                    <li><a class="dropdown-item fs--1 mb-0 font-sans-serif" href="#" id="de">Delete User</a></li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row ms-1">
                            <div class="col-6">
                              <div class="row col-12">
                                <div class="form-check">
                                  <input class="form-check-input web_access" type="checkbox" value="" id="web_access" name="web_access">
                                  <label class="form-check-label" for="flexCheckDefault" style="font-weight: 'bold'; font-size: 16px !important;">
                                    Web Application Access
                                  </label>
                                </div>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input webclass" type="checkbox" value="" id="outtasks" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                  Outbound Tasks
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input webclass" type="checkbox" value="" id="flexCheckChecked" disabled>
                                <label class="form-check-label" for="flexCheckChecked">
                                  Inbound Tasks
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input webclass" type="checkbox" value="" id="flexCheckChecked" disabled>
                                <label class="form-check-label" for="flexCheckChecked">
                                  Inventory
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input webclass" type="checkbox" value="" id="flexCheckChecked" disabled>
                                <label class="form-check-label" for="flexCheckChecked">
                                  Reports
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input webclass" type="checkbox" value="" id="flexCheckChecked" disabled>
                                <label class="form-check-label" for="flexCheckChecked">
                                  Settings
                                </label>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="row col-12">
                                <div class="form-check">
                                  <input class="form-check-input mob_access" type="checkbox" value="" id="mob_access" name="mob_access">
                                  <label class="form-check-label" for="flexCheckDefault" style="font-weight: 'bold'; font-size: 16px !important;">
                                    Mobile Application Access
                                  </label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-check">
                                    <input class="form-check-input mobclass" type="checkbox" value="" id="stock-enq" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                      Stock Enquiry
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input mobclass" type="checkbox" value="" id="stock-pick" disabled>
                                    <label class="form-check-label" for="flexCheckChecked">
                                      Stock Pick
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input mobclass" type="checkbox" value="" id="flexCheckChecked" disabled>
                                    <label class="form-check-label" for="flexCheckChecked">
                                      Packing
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input mobclass" type="checkbox" value="" id="flexCheckChecked" disabled>
                                    <label class="form-check-label" for="flexCheckChecked">
                                      Replenishment
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input mobclass" type="checkbox" value="" id="flexCheckChecked" disabled>
                                    <label class="form-check-label" for="flexCheckChecked">
                                      Goods Inwards
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input mobclass" type="checkbox" value="" id="flexCheckChecked" disabled>
                                    <label class="form-check-label" for="flexCheckChecked">
                                      Putaway
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input mobclass" type="checkbox" value="" id="flexCheckChecked" disabled>
                                    <label class="form-check-label" for="flexCheckChecked">
                                      Stock Returns
                                    </label>
                                  </div>
                                </div>

                                <div class="col-6">
                                  <div class="form-check">
                                    <input class="form-check-input mobclass" type="checkbox" value="" id="flexCheckDefault" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                      Dispatch
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input mobclass" type="checkbox" value="" id="flexCheckChecked" disabled>
                                    <label class="form-check-label" for="flexCheckChecked">
                                      Stock Locations
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input mobclass" type="checkbox" value="" id="flexCheckChecked" disabled>
                                    <label class="form-check-label" for="flexCheckChecked">
                                      PLU Maintenance
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input mobclass" type="checkbox" value="" id="flexCheckChecked" disabled>
                                    <label class="form-check-label" for="flexCheckChecked">
                                      Stocktake
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input mobclass" type="checkbox" value="" id="flexCheckChecked" disabled>
                                    <label class="form-check-label" for="flexCheckChecked">
                                      Cycle Count
                                    </label>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>


                        </div>



                      </div>
                      <div class="tab-pane" id="user-manage" role="tabpanel" aria-labelledby="user-manage-tab">
                        <div class="echart-user-manage" data-echart-responsive="true" data-echart-tab="data-echart-tab" style="height:360px;">No subscription available</div>
                      </div>
                      <div class="tab-pane" id="user-settings-master" role="tabpanel" aria-labelledby="user-settings-master-tab">
                        <div class="echart-user-settings-master" data-echart-responsive="true" data-echart-tab="data-echart-tab" style="height:360px;">No subscription available</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-3">
            <div class="card" style="min-height:454px !important">
              <div class="card-header d-flex flex-between-center py-2 border-bottom">
                <h6 class="mb-0">User Licences</h6>
                <div class="dropdown font-sans-serif btn-reveal-trigger">
                  <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-most-leads" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-most-leads"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                  </div>
                </div>
              </div>
              <div class="card-body d-flex flex-column justify-content-between">
                <div class="row align-items-center">
                  <div class="col-md-5 col-xxl-12 mb-xxl-1">
                    <div class="position-relative">
                      <!-- Find the JS file for the following chart at: src/js/charts/echarts/most-leads.js-->
                      <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                      <div class="echart-most-leads my-2" data-echart-responsive="true"></div>
                      <div class="position-absolute top-50 start-50 translate-middle text-center">
                        <p class="fs--1 mb-0 text-400 font-sans-serif fw-medium">Total Profiles</p>

                        <?php
                        require(__DIR__ . '../../../dbconnect/db.php');

                        $sql = "SELECT COUNT(em) as 'counter' FROM INB_USERMASTER";

                        $stmt = $conn->prepare($sql);
                        // $stmt->bind_param("s", $search);
                        // $search = $findOrder;
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if (mysqli_num_rows($result) > 0) {
                          while ($row = $result->fetch_assoc()) {
                            //   echo '<option value=' . $row["UserCode"] . '>' . $row["fname"] . ' ' . $row["lname"] . '</option>';
                            echo "<p class='fs-3 mb-0 font-sans-serif fw-medium mt-n2'>" . $row["counter"] . "</p>";
                          }
                        } else {
                          echo "<p class='fs-3 mb-0 font-sans-serif fw-medium mt-n2'>0</p>";
                        }
                        ?>



                      </div>

                      <div class="position-absolute top-60 start-50 translate-middle text-center">
                        <p class="fs--1 mb-0 text-400 font-sans-serif fw-medium">Active Profiles</p>

                        <?php
                        require(__DIR__ . '../../../dbconnect/db.php');

                        $sql = "SELECT COUNT(em) as 'counter' FROM INB_USERMASTER WHERE ActiveStatus='1'";

                        $stmt = $conn->prepare($sql);
                        // $stmt->bind_param("s", $search);
                        // $search = $findOrder;
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if (mysqli_num_rows($result) > 0) {
                          while ($row = $result->fetch_assoc()) {
                            //   echo '<option value=' . $row["UserCode"] . '>' . $row["fname"] . ' ' . $row["lname"] . '</option>';
                            echo "<p class='fs-3 mb-0 font-sans-serif fw-medium mt-n2'>" . $row["counter"] . "</p>";
                          }
                        } else {
                          echo "<p class='fs-3 mb-0 font-sans-serif fw-medium mt-n2'>0</p>";
                        }
                        ?>



                      </div>

                    </div>
                  </div>
                  <!-- <div class="col-xxl-12 col-md-7">
                    <hr class="mx-ncard mb-0 d-md-none d-xxl-block" />
                    <div class="d-flex flex-between-center border-bottom py-3 pt-md-0 pt-xxl-3">
                      <div class="d-flex"><img class="me-2" src="../assets/img/crm/email.svg " width="16" height="16" alt="..." />
                        <h6 class="text-700 mb-0">Email </h6>
                      </div>
                      <p class="fs--1 text-500 mb-0 fw-semi-bold">5200 vs 1052</p>
                      <h6 class="text-700 mb-0">12%</h6>
                    </div>
                    <div class="d-flex flex-between-center border-bottom py-3">
                      <div class="d-flex"><img class="me-2" src="../assets/img/crm/social.svg " width="16" height="16" alt="..." />
                        <h6 class="text-700 mb-0">Social </h6>
                      </div>
                      <p class="fs--1 text-500 mb-0 fw-semi-bold">5623 vs 4929</p>
                      <h6 class="text-700 mb-0">25%</h6>
                    </div>
                    <div class="d-flex flex-between-center border-bottom py-3">
                      <div class="d-flex"><img class="me-2" src="../assets/img/crm/call.svg " width="16" height="16" alt="..." />
                        <h6 class="text-700 mb-0">Call </h6>
                      </div>
                      <p class="fs--1 text-500 mb-0 fw-semi-bold">2535 vs 1486</p>
                      <h6 class="text-700 mb-0">63%</h6>
                    </div>
                    <div class="d-flex flex-between-center border-bottom py-3 border-bottom-0 pb-0">
                      <div class="d-flex"><img class="me-2" src="../assets/img/crm/other.svg " width="16" height="16" alt="..." />
                        <h6 class="text-700 mb-0">Other </h6>
                      </div>
                      <p class="fs--1 text-500 mb-0 fw-semi-bold">256 vs 189</p>
                      <h6 class="text-700 mb-0">53%</h6>
                    </div>
                  </div> -->
                </div>
              </div>
              <div class="card-footer bg-light p-0"><a class="btn btn-sm btn-link d-block py-2" href="../user_details/" target="_blank" rel="noopener noreferrer">View All<span class="fas fa-chevron-right ms-1 fs--2"></span></a></div>
            </div>

            <div class="modal fade" id="confirmDeactivate" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="confirmDeactivateLabel" aria-hidden="true">
              <div class="modal-dialog mt-6" role="document">
                <div class="modal-content border-0">
                  <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" id="reasonmodalclose" aria-label="Close"></button></div>
                  <div class="modal-body p-0">
                    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                      <h4 class="mb-1" id="confirmDeactivateLabel">Alert</h4>
                      <!-- <p class="fs--2 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
                    </div>
                    <div class="p-4">
                      <div class="row">
                        <div class="col-lg-12">
                          <!-- <div class="d-flex"> -->
                          <div class="flex-1">
                            <h5 class="mb-2 fs-0" id="customMessage"></h5>
                          </div>
                          <!-- </div> -->
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-falcon-secondary btn-sm" id="cleanmereason">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>



          <!-- ===============================================-->
          <!--    JavaScripts-->
          <!-- ===============================================-->
          <?php include('../common/footer.html'); ?>

</body>

</html>

<script>
  $(document).ready(function(fw) {
    $('#addnewuser').on('click', function(e) {
      e.preventDefault();

      var un = $('#fname').val();
      var ln = $('#lname').val();
      var uc = $('#ucode').val();
      var be = $('#busemail').val();
      var pi = $('#platformid').val();
      var pw = $('#pw').val();
      var acc = $('#accesslevel option:selected').val();
      var rpw = $('#repw').val();

      if (un == '') {
        $('#alert-msg').html('<p style="color: var(--falcon-red); font-size: 13px;">First name required</p>');
      } else if (ln == '') {
        $('#alert-msg').html('<p style="color: var(--falcon-red); font-size: 13px;">Last name required</p>');
      } else if (uc == '') {
        $('#alert-msg').html('<p style="color: var(--falcon-red); font-size: 13px;">User code required</p>');
      } else if (uc.length != 3) {
        $('#alert-msg').html('<p style="color: var(--falcon-red); font-size: 13px;">User code must be 3 letters</p>');
      } else if (pi == '') {
        $('#alert-msg').html('<p style="color: var(--falcon-red); font-size: 13px;">Platform ID required</p>');
      } else if(acc === 'selectaccess') {
        $('#alert-msg').html('<p style="color: var(--falcon-red); font-size: 13px;">Access level required</p>');
      } else if (pw == '') {
        $('#alert-msg').html('<p style="color: var(--falcon-red); font-size: 13px;">Please enter a password</p>');
      } else if (rpw == '') {
        $('#alert-msg').html('<p style="color: var(--falcon-red); font-size: 13px;">Please confirm password</p>');
      } else if (pw != rpw) {
        $('#alert-msg').html('<p style="color: var(--falcon-red); font-size: 13px;">Password mismatch! Try again</p>');
      } else {

        $.ajax({
          url: "_adusr.php",
          type: "POST",
          data: {
            un: un,
            ln: ln,
            uc: uc,
            be: be,
            pi: pi,
            pw: pw,
            rpw: rpw,
            accs: acc
          },
          success: function(result) {
            $('#alert-msg').html(result);
            $('#fname').val('');
            $('#lname').val('');
            $('#ucode').val('');
            $('#busemail').val('');
            $('#platformid').val('');
            $('#pw').val('');
            $('#accesslevel').prop('selectedIndex', 0);
            $('#repw').val('');
          }
        });
      }
    })

    $('[name="web_access"]').change(function() {
      if ($(this).is(':checked')) {
        $("input.webclass").removeAttr("disabled");
      } else {
        $("input.webclass").attr("disabled", true);
        $("input.webclass").prop("checked", false);
      }
    })

    $('[name="mob_access"]').change(function() {
      if ($(this).is(':checked')) {
        $("input.mobclass").removeAttr("disabled");
      } else {
        $("input.mobclass").attr("disabled", true);
        $("input.mobclass").prop("checked", false);
      }
    })

    $('#ia').on('click', function(c) {
      c.preventDefault();
      var user_ = $('#_upkr option:selected').val();
      if (user_ === 'selectpicker') {
        $('#customMessage').html('No user selected.');
        $('#confirmDeactivate').modal('show');
      } else {
        $.ajax({
          url: "_inc.php",
          type: "POST",
          data: {
            usr: user_
          },
          success: function(result) {
            // $('#alert-msg').html(result);
            $('#customMessage').html(result);
            $('#confirmDeactivate').modal('show');
            $('#_upkr').prop('selectedIndex', 0);
          }
        });
      }
    });

    $('#ac').on('click', function(cx) {
      cx.preventDefault();
      var user_ = $('#_upkr option:selected').val();
      if (user_ === 'selectpicker') {
        $('#customMessage').html('No user selected.');
        $('#confirmDeactivate').modal('show');
      } else {
        $.ajax({
          url: "_act.php",
          type: "POST",
          data: {
            usrx: user_
          },
          success: function(result) {
            // $('#alert-msg').html(result);
            $('#customMessage').html(result);
            $('#confirmDeactivate').modal('show');
            $('#_upkr').prop('selectedIndex', 0);
          }
        });
      }
    });

    $('#de').on('click', function(c) {
      c.preventDefault();
      var user_ = $('#_upkr option:selected').val();
      if (user_ === 'selectpicker') {
        $('#customMessage').html('No user selected.');
        $('#confirmDeactivate').modal('show');
      } else {
        $.ajax({
          url: "_del.php",
          type: "POST",
          data: {
            usrx: user_
          },
          success: function(result) {
            if(result === 'nopreviledges') {
              $('#customMessage').html('Access limitations applied. Can not delete user profiles.');
              $('#confirmDeactivate').modal('show');
              $('#_upkr').prop('selectedIndex', 0);
            } else if(result === 'error_') {
              $('#customMessage').html('Error deleting the profile. Please refresh the browser and try again.');
              $('#confirmDeactivate').modal('show');
              $('#_upkr').prop('selectedIndex', 0);
            } else if(result === 'deleted') {
              $('#customMessage').html('Successfully deleted.');
              $('#confirmDeactivate').modal('show');
              $('#_upkr').prop('selectedIndex', 0);
            }
          }
        });
      }

       
    })
   
    $('#reasonmodalclose').on('click', function(gcz) {
    gcz.preventDefault();
    var txt = $('#customMessage').html();
    if(txt === 'Successfully deleted.') {
      $('#confirmDeactivate').modal('hide');
      $('#customMessage').html('');
      location.reload();
    } else {
      $('#confirmDeactivate').modal('hide');
      $('#customMessage').html('');
    }
  })

    $('#cleanmereason').on('click', function(gcz) {
    gcz.preventDefault();
    var txt = $('#customMessage').html();
    if(txt === 'Successfully deleted.') {
      $('#confirmDeactivate').modal('hide');
      $('#customMessage').html('');
      location.reload();
    } else {
      $('#confirmDeactivate').modal('hide');
      $('#customMessage').html('');
    }
  })

  })
</script>